<?php

namespace App\Components\Content\Infrastructure\Query;

use App\Components\Content\Application\Query\BlogTreeQuery;
use App\Components\Content\Application\Query\Model\BlogCategoryCollection;
use App\Components\Content\Infrastructure\Entity\BlogCategory as CategoryEntity;
use App\Components\Content\Infrastructure\Query\Model\BlogFactory;

class BlogEloquentTreeQuery implements BlogTreeQuery
{
    /** @var CategoryEntity */
    private $db;

    /** @var BlogFactory */
    private $factory;

    /**
     * BlogEloquentTreeQuery constructor.
     *
     * @param CategoryEntity $db
     * @param BlogFactory    $factory
     */
    public function __construct(CategoryEntity $db, BlogFactory $factory)
    {
        $this->db = $db;
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function findParentCategoryCollection(): BlogCategoryCollection
    {
        $collection = new BlogCategoryCollection();

        $query = $this->db->newQuery()
            ->whereNull('parent_id')
            ->orderBy('position')
            ->orderBy('created_at')
        ;

        /** @var CategoryEntity $entity */
        foreach ($query->get()->all() as $entity) {
            $collection->add($this->factory->buildCategory($entity));
        }

        return $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function findChildrenCategoryCollection(string $parentId): BlogCategoryCollection
    {
        $collection = new BlogCategoryCollection();

        $query = $this->db->newQuery()
            ->where('parent_id', '=', $parentId)
            ->orderBy('position')
            ->orderBy('created_at')
        ;

        /** @var CategoryEntity $entity */
        foreach ($query->get()->all() as $entity) {
            $collection->add($this->factory->buildCategory($entity));
        }

        return $collection;
    }
}
