<?php

namespace App\System\Messaging\Command;

use App\System\Messaging\Message;

abstract class Command implements Message
{
    /**
     * {@inheritdoc}
     */
    public function messageName(): string
    {
        return \get_called_class();
    }
}
