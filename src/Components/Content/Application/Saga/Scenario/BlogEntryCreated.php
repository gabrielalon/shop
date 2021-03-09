<?php

namespace App\Components\Content\Application\Saga\Scenario;

use App\System\Messaging\Saga\Scenario;
use Carbon\Carbon;

class BlogEntryCreated implements Scenario
{
    /** @var string */
    private $id;

    /** @var string[] */
    private $name;

    /** @var string[] */
    private $description;

    /** @var Carbon */
    private $publishAt;

    /** @var string[] */
    private $categoriesID;

    /**
     * BlogEntryCreated constructor.
     *
     * @param string   $id
     * @param string[] $name
     * @param string[] $description
     * @param Carbon   $publishAt
     * @param string[] $categoriesID
     */
    public function __construct(
        string $id,
        array $name,
        array $description,
        Carbon $publishAt,
        array $categoriesID
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->publishAt = $publishAt;
        $this->categoriesID = $categoriesID;
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

    /**
     * @return string[]
     */
    public function description(): array
    {
        return $this->description;
    }

    /**
     * @return Carbon
     */
    public function publishAt(): Carbon
    {
        return $this->publishAt;
    }

    /**
     * @return string[]
     */
    public function categoriesID(): array
    {
        return $this->categoriesID;
    }
}
