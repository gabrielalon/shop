<?php

namespace App\Components\Content\Application\Saga\Scenario;

use App\System\Messaging\Saga\Scenario;

class BlogEntryRemoved implements Scenario
{
    /** @var string */
    private $id;

    /**
     * BlogEntryRemoved constructor.
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
