<?php

namespace App\System\Messaging\Saga\Metadata;

use App\System\Messaging\Aggregate\AggregateId;
use App\System\Messaging\Saga\SagaRoot;
use App\System\Messaging\Saga\Scenario;

class Metadata
{
    /** @var SagaRoot */
    private $saga;

    /**
     * Metadata constructor.
     *
     * @param SagaRoot $saga
     */
    public function __construct(SagaRoot $saga)
    {
        $this->saga = $saga;
    }

    /**
     * @param Scenario $scenario
     *
     * @return bool
     */
    public function handles(Scenario $scenario): bool
    {
        $scenarioName = $this->getClassName($scenario);

        return isset($this->saga->configuration()[$scenarioName]);
    }

    /**
     * @param Scenario $scenario
     *
     * @return AggregateId|null
     */
    public function criteria(Scenario $scenario): ?AggregateId
    {
        $scenarioName = $this->getClassName($scenario);

        if (true === isset($this->saga->configuration()[$scenarioName])) {
            return $this->saga->configuration()[$scenarioName]($scenario);
        }

        return null;
    }

    /**
     * @param Scenario $scenario
     *
     * @return string
     */
    public function getClassName(Scenario $scenario): string
    {
        return get_class($scenario);
    }
}
