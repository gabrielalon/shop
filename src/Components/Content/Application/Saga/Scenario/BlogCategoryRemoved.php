<?php

namespace App\Components\Content\Application\Saga\Scenario;

use App\System\Messaging\Saga\Scenario;

class BlogCategoryRemoved implements Scenario
{
    /** @var string */
    private string $id;

    /**
     * BlogCategoryRemoved constructor.
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
