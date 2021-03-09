<?php

namespace App\Components\Content\Infrastructure\Query;

use App\Components\Content\Application\Query\BlogQuery;
use App\Components\Content\Application\Query\Exception\BlogCategoryNotFoundException;
use App\Components\Content\Application\Query\Exception\BlogEntryNotFoundException;
use App\Components\Content\Application\Query\Model\BlogCategory;
use App\Components\Content\Application\Query\Model\BlogCategoryCollection;
use App\Components\Content\Application\Query\Model\BlogEntry;
use App\Components\Content\Application\Query\Model\BlogEntryCollection;
use App\Components\Content\Infrastructure\Entity\BlogCategory as CategoryEntity;
use App\Components\Content\Infrastructure\Entity\BlogEntry as EntryEntity;
use App\Components\Content\Infrastructure\Query\Model\BlogFactory;

class BlogEloquentQuery implements BlogQuery
{
    /** @var BlogFactory */
    private $factory;

    /** @var EntryEntity */
    private $entryDB;

    /** @var CategoryEntity */
    private $categoryDB;

    /**
     * BlogEloquentQuery constructor.
     *
     * @param BlogFactory    $factory
     * @param EntryEntity    $entryDB
     * @param CategoryEntity $categoryDB
     */
    public function __construct(BlogFactory $factory, EntryEntity $entryDB, CategoryEntity $categoryDB)
    {
        $this->factory = $factory;
        $this->entryDB = $entryDB;
        $this->categoryDB = $categoryDB;
    }

    /**
     * {@inheritdoc}
     */
    public function findCategoryById(string $id): BlogCategory
    {
        /** @var CategoryEntity $entity */
        if ($entity = $this->categoryDB->newQuery()->find($id)) {
            return $this->factory->buildCategory($entity);
        }

        throw BlogCategoryNotFoundException::fromId($id);
    }

    /**
     * {@inheritdoc}
     */
    public function findCategoryCollection(): BlogCategoryCollection
    {
        $collection = new BlogCategoryCollection();

        /** @var CategoryEntity $entity */
        foreach ($this->categoryDB->newQuery()->get()->all() as $entity) {
            $collection->add($this->factory->buildCategory($entity));
        }

        return $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function findCategoryCollectionLike(string $query): BlogCategoryCollection
    {
        $collection = new BlogCategoryCollection();
        $categoryDB = $this->categoryDB
            ->newQuery()->selectRaw('blog_category.*')
            ->join(
                'blog_category_translation',
                'blog_category_translation.blog_category_id',
                '=',
                'blog_category.id'
            )
            ->where(
                'blog_category_translation.name',
                'LIKE',
                '%'.$query.'%'
            )
            ->groupBy(['blog_category.id'])
        ;

        /** @var CategoryEntity $entity */
        foreach ($categoryDB->get()->all() as $entity) {
            $collection->add($this->factory->buildCategory($entity));
        }

        return $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function findEntryById(string $id): BlogEntry
    {
        /** @var EntryEntity $entity */
        if ($entity = $this->entryDB->newQuery()->find($id)) {
            return $this->factory->buildEntry($entity);
        }

        throw BlogEntryNotFoundException::fromId($id);
    }

    /**
     * {@inheritdoc}
     */
    public function findEntryCollection(): BlogEntryCollection
    {
        $collection = new BlogEntryCollection();

        /** @var EntryEntity $entity */
        foreach ($this->entryDB->newQuery()->get()->all() as $entity) {
            $collection->add($this->factory->buildEntry($entity));
        }

        return $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function findEntryCategoryCollection(string $id): BlogCategoryCollection
    {
        $collection = new BlogCategoryCollection();

        /** @var EntryEntity $entry */
        if ($entry = $this->entryDB->newQuery()->find($id)) {
            /** @var CategoryEntity $entity */
            foreach ($entry->categories()->get()->all() as $entity) {
                $collection->add($this->factory->buildCategory($entity));
            }
        }

        return $collection;
    }
}
