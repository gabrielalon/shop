<?php

namespace App\System\Messaging;

interface Message
{
    /**
     * @return string
     */
    public function messageName(): string;
}
