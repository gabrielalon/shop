<?php

namespace App\System\Messaging\Saga\Metadata;

use App\System\Messaging\Saga\SagaRoot;

interface MetadataFactory
{
    /**
     * @param SagaRoot $saga
     *
     * @return Metadata
     */
    public function create(SagaRoot $saga): Metadata;
}
