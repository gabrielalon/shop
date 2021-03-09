<?php

namespace App\System\Messaging\Saga\Metadata;

use App\System\Messaging\Saga\SagaRoot;

class SagaMetadataFactory implements MetadataFactory
{
    /**
     * {@inheritdoc}
     */
    public function create(SagaRoot $saga): Metadata
    {
        return new Metadata($saga);
    }
}
