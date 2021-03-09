<?php

namespace App\System\Messaging\Saga;

use App\System\Messaging\Saga\Metadata\Metadata;

abstract class SagaRoot
{
    /**
     * @return array
     */
    abstract public function configuration(): array;

    /**
     * @param Metadata $metadata
     * @param Scenario $scenario
     * @param State    $state
     *
     * @return State
     */
    public function handle(Metadata $metadata, Scenario $scenario, State $state): State
    {
        $method = $this->getHandleMethod($scenarioName = $metadata->getClassName($scenario));

        if (!method_exists($this, $method)) {
            $message = sprintf("No handle method '%s' for event '%s'.", $method, $scenarioName);

            throw new \BadMethodCallException($message);
        }

        return $this->$method($scenario, $state);
    }

    /**
     * @param string $scenarioName
     *
     * @return string
     */
    private function getHandleMethod(string $scenarioName): string
    {
        $classParts = explode('\\', $scenarioName);

        return 'handle'.end($classParts);
    }
}
