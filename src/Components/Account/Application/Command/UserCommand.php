<?php

namespace App\Components\Account\Application\Command;

use App\System\Messaging\Command\Command;

abstract class UserCommand extends Command
{
    /** @var string */
    private $id;

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    protected function setId(string $id): void
    {
        $this->id = $id;
    }
}
