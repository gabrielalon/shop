<?php

namespace App\Components\Content\Domain;

use App\System\Messaging\Aggregate\AggregateRoot;
use App\System\Valuing as VO;
use Carbon\Carbon;

final class BlogEntry extends AggregateRoot
{
    /** @var VO\Identity\Uuids */
    private $categories;

    /** @var VO\Option\Check */
    private $active;

    /** @var Carbon */
    private $publishAt;

    /** @var VO\Intl\Language\Texts */
    private $name;

    /** @var VO\Intl\Language\Contents */
    private $description;

    /**
     * @param VO\Identity\Uuid $id
     *
     * @return BlogEntry
     */
    public function setId(VO\Identity\Uuid $id): BlogEntry
    {
        $this->setAggregateId($id);

        return $this;
    }

    /**
     * @param VO\Identity\Uuids $categories
     *
     * @return BlogEntry
     */
    public function setCategories(VO\Identity\Uuids $categories): BlogEntry
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @param VO\Option\Check $active
     *
     * @return BlogEntry
     */
    public function setActive(VO\Option\Check $active): BlogEntry
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @param Carbon $publishAt
     *
     * @return BlogEntry
     */
    public function setPublishAt(Carbon $publishAt): BlogEntry
    {
        $this->publishAt = $publishAt;

        return $this;
    }

    /**
     * @param VO\Intl\Language\Texts $name
     *
     * @return BlogEntry
     */
    public function setName(VO\Intl\Language\Texts $name): BlogEntry
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param VO\Intl\Language\Contents $description
     *
     * @return BlogEntry
     */
    public function setDescription(VO\Intl\Language\Contents $description): BlogEntry
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param string $id
     *
     * @return BlogEntry
     */
    public static function create(string $id): BlogEntry
    {
        $entry = new static();

        $entry->recordThat(Event\BlogEntryCreated::occur($id));

        return $entry;
    }

    /**
     * @param string[] $name
     * @param string[] $description
     */
    public function translate(array $name, array $description): void
    {
        $this->recordThat(Event\BlogEntryTranslated::occur($this->aggregateId(), [
            'name' => $name,
            'description' => $description,
        ]));
    }

    /**
     * @param array $categoriesId
     */
    public function categorise(array $categoriesId): void
    {
        $this->recordThat(Event\BlogEntryCategorisedEvent::occur($this->aggregateId(), [
            'categories_id' => $categoriesId,
        ]));
    }

    /**
     * @param Carbon $publishAt
     */
    public function publish(Carbon $publishAt): void
    {
        $this->recordThat(Event\BlogEntryPublished::occur($this->aggregateId(), [
            'publish_at' => $publishAt->toDateTimeString(),
        ]));
    }

    public function activate(): void
    {
        $this->recordThat(Event\BlogEntryActivated::occur($this->aggregateId()));
    }

    public function deactivate(): void
    {
        $this->recordThat(Event\BlogEntryDeactivated::occur($this->aggregateId()));
    }

    public function remove(): void
    {
        $this->recordThat(Event\BlogEntryRemoved::occur($this->aggregateId()));
    }
}
