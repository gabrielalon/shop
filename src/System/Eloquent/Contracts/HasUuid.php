<?php

namespace App\System\Eloquent\Contracts;

interface HasUuid
{
    /**
     * @return string
     */
    public function getUuidFieldName(): string;
}
