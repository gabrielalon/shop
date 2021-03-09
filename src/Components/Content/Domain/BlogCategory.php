<?php

namespace App\Components\Content\Domain;

use App\System\Messaging\Aggregate\AggregateRoot;
use App\System\Valuing as VO;

final class BlogCategory extends AggregateRoot
{
    /** @var VO\Intl\Language\Texts */
    private $name;

    /** @var VO\Option\Check */
    private $active;

    /** @var VO\Number\Number */
    private $position;

    /** @var VO\Identity\Uuid|null */
    private $parentId;

    /**
     * @param VO\Identity\Uuid $id
     *
     * @return BlogCategory
     */
    public function setId(VO\Identity\Uuid $id): BlogCategory
    {
        $this->setAggregateId($id);

        return $this;
    }

    /**
     * @param VO\Intl\Language\Texts $name
     *
     * @return BlogCategory
     */
    public function setName(VO\Intl\Language\Texts $name): BlogCategory
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param VO\Option\Check $active
     *
     * @return BlogCategory
     */
    public function setActive(VO\Option\Check $active): BlogCategory
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @param VO\Number\Number $position
     *
     * @return BlogCategory
     */
    public function setPosition(VO\Number\Number $position): BlogCategory
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @param VO\Identity\Uuid|null $parentId
     *
     * @return BlogCategory
     */
    public function setParentId(?VO\Identity\Uuid $parentId): BlogCategory
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * @param string $id
     *
     * @return BlogCategory
     */
    public static function create(string $id): BlogCategory
    {
        $entry = new static();

        $entry->recordThat(Event\BlogCategoryCreated::occur($id));

        return $entry;
    }

    /**
     * @param string[] $name
     */
    public function translate(array $name): void
    {
        $this->recordThat(Event\BlogCategoryTranslated::occur($this->aggregateId(), [
            'name' => $name,
        ]));
    }

    public function activate(): void
    {
        $this->recordThat(Event\BlogCategoryActivated::occur($this->aggregateId()));
    }

    public function deactivate(): void
    {
        $this->recordThat(Event\BlogCategoryDeactivated::occur($this->aggregateId()));
    }

    /**
     * @param int         $position
     * @param string|null $parentId
     */
    public function position(int $position, ?string $parentId = null): void
    {
        $this->recordThat(Event\BlogCategoryPositioned::occur($this->aggregateId(), [
            'position' => $position,
            'parent_id' => $parentId,
        ]));
    }

    public function remove(): void
    {
        $this->recordThat(Event\BlogCategoryRemoved::occur($this->aggregateId()));
    }
}
