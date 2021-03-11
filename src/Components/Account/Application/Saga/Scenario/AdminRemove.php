<?php

namespace App\Components\Account\Application\Saga\Scenario;

use App\System\Messaging\Saga\Scenario;

final class AdminRemove implements Scenario
{
    /** @var string */
    private string $id;

    /**
     * AdminRemove constructor.
     *
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }
}
