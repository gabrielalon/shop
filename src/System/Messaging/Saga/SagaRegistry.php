<?php

namespace App\System\Messaging\Saga;

class SagaRegistry
{
    /** @var SagaRoot[] */
    private $saga;

    /**
     * SagaRegistry constructor.
     */
    public function __construct()
    {
        $this->saga = [];
    }

    /**
     * @param SagaRoot $saga
     *
     * @return SagaRegistry
     */
    public function register(SagaRoot $saga): SagaRegistry
    {
        $this->saga[get_class($saga)] = $saga;

        return $this;
    }

    /**
     * @return SagaRoot[]
     */
    public function all(): array
    {
        return $this->saga;
    }
}
