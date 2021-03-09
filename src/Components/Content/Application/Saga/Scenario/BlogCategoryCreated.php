<?php

namespace App\Components\Content\Application\Saga\Scenario;

use App\System\Messaging\Saga\Scenario;

class BlogCategoryCreated implements Scenario
{
    /** @var string */
    private $id;

    /** @var string[] */
    private $name;

    /**
     * BlogCategoryCreated constructor.
     *
     * @param string   $id
     * @param string[] $name
     */
    public function __construct(string $id, array $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string[]
     */
    public function name(): array
    {
        return $this->name;
    }
}
