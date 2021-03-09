<?php

namespace App\Components\Content\Infrastructure\Query\Model;

use App\Components\Content\Application\Query\Model\BlogCategory;
use App\Components\Content\Application\Query\Model\BlogCategoryCollection;
use App\Components\Content\Application\Query\Model\BlogEntry;
use App\Components\Content\Infrastructure\Entity\BlogCategory as CategoryEntity;
use App\Components\Content\Infrastructure\Entity\BlogEntry as EntryEntity;
use Carbon\Carbon;
use Illuminate\Support\Str;

class BlogFactory
{
    /**
     * @param CategoryEntity $entity
     *
     * @return BlogCategory
     */
    public function buildCategory(CategoryEntity $entity): BlogCategory
    {
        return new BlogCategory($entity->id, $entity->name(), $entity->is_active);
    }

    /**
     * @return BlogCategory
     */
    public function buildEmptyCategory(): BlogCategory
    {
        return new BlogCategory(Str::uuid()->toString(), [], false);
    }

    /**
     * @param EntryEntity $entity
     *
     * @return BlogEntry
     */
    public function buildEntry(EntryEntity $entity): BlogEntry
    {
        return new BlogEntry(
            $entity->id,
            $entity->name(),
            $entity->description(),
            $entity->publish_at,
            $entity->is_active,
            $this->buildEntryCategories($entity->categories()->get()->all())
        );
    }

    /**
     * @return BlogEntry
     */
    public function buildEmptyEntry(): BlogEntry
    {
        return new BlogEntry(
            Str::uuid()->toString(),
            [],
            [],
            Carbon::now(),
            false,
            new BlogCategoryCollection()
        );
    }

    /**
     * @param CategoryEntity[] $categories
     *
     * @return BlogCategoryCollection
     */
    protected function buildEntryCategories(array $categories): BlogCategoryCollection
    {
        $collection = new BlogCategoryCollection();

        foreach ($categories as $entity) {
            $collection->add($this->buildCategory($entity));
        }

        return $collection;
    }
}
