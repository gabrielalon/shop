<?php

namespace App\System\Messaging\Saga;

use App\System\Eloquent\Connection;
use App\System\Messaging\Saga\Metadata\MetadataFactory;
use App\System\Messaging\Saga\State\StateManager;

class SagaManager
{
    /** @var Connection */
    private $connection;

    /** @var SagaRegistry */
    private $sagaRegistry;

    /** @var StateManager */
    private $stateManager;

    /** @var MetadataFactory */
    private $metadataFactory;

    /**
     * SagaManager constructor.
     *
     * @param Connection      $connection
     * @param SagaRegistry    $sagaRegistry
     * @param StateManager    $stateManager
     * @param MetadataFactory $metadataFactory
     */
    public function __construct(
        Connection $connection,
        SagaRegistry $sagaRegistry,
        StateManager $stateManager,
        MetadataFactory $metadataFactory
    ) {
        $this->connection = $connection;
        $this->sagaRegistry = $sagaRegistry;
        $this->stateManager = $stateManager;
        $this->metadataFactory = $metadataFactory;
    }

    /**
     * @param Scenario $scenario
     *
     * @throws \Exception
     */
    public function handle(Scenario $scenario): void
    {
        foreach ($this->sagaRegistry->all() as $sagaType => $saga) {
            $metadata = $this->metadataFactory->create($saga);

            if (false === $metadata->handles($scenario)) {
                continue;
            }

            $state = $this->stateManager->findOneByAggregateSaga($metadata->criteria($scenario), $sagaType);
            if (null === $state) {
                continue;
            }

            try {
                $this->connection->beginTransaction();
                $newState = $saga->handle($metadata, $scenario, $state);

                $this->stateManager->store($newState, $sagaType);
                $this->connection->commit();
            } catch (\Exception $exception) {
                $this->connection->rollBack();
                throw $exception;
            }
        }
    }
}
