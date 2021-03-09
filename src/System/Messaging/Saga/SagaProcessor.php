<?php

namespace App\System\Messaging\Saga;

class SagaProcessor
{
    /** @var SagaManager */
    private $sagaManager;

    /**
     * ScenarioProcessor constructor.
     *
     * @param SagaManager $sagaManager
     */
    public function __construct(SagaManager $sagaManager)
    {
        $this->sagaManager = $sagaManager;
    }

    /**
     * @param Scenario $scenario
     *
     * @throws \Exception
     */
    public function run(Scenario $scenario): void
    {
        $this->sagaManager->handle($scenario);
    }
}
