<?php

namespace App\System\Lock\Exception;

class MutexFailedException extends \RuntimeException
{
    /**
     * MutexFailedException constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $message = \sprintf('Mutex for name %s failed.', $name);
        parent::__construct($message, 500, $previous = null);
    }
}
