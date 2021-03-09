<?php

namespace App\Components\Content\Application\Saga\Scenario;

use App\System\Messaging\Saga\Scenario;

class BlogCategorySorted implements Scenario
{
    /** @var array */
    private $data;

    /**
     * BlogCategorySorted constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return $this->data;
    }
}
