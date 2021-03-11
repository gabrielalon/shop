<?php

namespace App\System\Eloquent\Contracts;

interface HasCode
{
    /**
     * @return string
     */
    public function getCodeFieldName(): string;
}
