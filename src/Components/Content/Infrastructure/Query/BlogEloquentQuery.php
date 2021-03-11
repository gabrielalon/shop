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

final class BlogEloquentQuery implements BlogQuery
{
    /** @var BlogFactory */
    private BlogFactory $factory;

    /** @var EntryEntity */
    private EntryEntity $entryDB;

    /** @var CategoryEntity */
    private CategoryEntity $categoryDB;

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
        if ($entity = $this->categoryDB::findByUuid($id)) {
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

        foreach ($this->categoryDB->newQuery()->get()->all() as $entity) {
            assert($entity instanceof CategoryEntity);
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

        foreach ($categoryDB->get()->all() as $entity) {
            assert($entity instanceof CategoryEntity);
            $collection->add($this->factory->buildCategory($entity));
        }

        return $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function findEntryById(string $id): BlogEntry
    {
        if ($entity = $this->entryDB::findByUuid($id)) {
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

        foreach ($this->entryDB->newQuery()->get()->all() as $entity) {
            assert($entity instanceof EntryEntity);
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

        if ($entry = $this->entryDB::findByUuid($id)) {
            foreach ($entry->categories()->get()->all() as $entity) {
                assert($entity instanceof CategoryEntity);
                $collection->add($this->factory->buildCategory($entity));
            }
        }

        return $collection;
    }
}
