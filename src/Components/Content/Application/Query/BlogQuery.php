<?php

namespace App\Components\Content\Application\Query;

use App\Components\Content\Application\Query\Exception\BlogCategoryNotFoundException;
use App\Components\Content\Application\Query\Exception\BlogEntryNotFoundException;
use App\Components\Content\Application\Query\Model\BlogCategory;
use App\Components\Content\Application\Query\Model\BlogCategoryCollection;
use App\Components\Content\Application\Query\Model\BlogEntry;
use App\Components\Content\Application\Query\Model\BlogEntryCollection;
use App\System\Messaging\Query\Query;

interface BlogQuery extends Query
{
    /**
     * @param string $id
     *
     * @return BlogCategory
     *
     * @throws BlogCategoryNotFoundException
     */
    public function findCategoryById(string $id): BlogCategory;

    /**
     * @return BlogCategoryCollection
     */
    public function findCategoryCollection(): BlogCategoryCollection;

    /**
     * @param string $query
     *
     * @return BlogCategoryCollection
     */
    public function findCategoryCollectionLike(string $query): BlogCategoryCollection;

    /**
     * @param string $id
     *
     * @return BlogEntry
     *
     * @throws BlogEntryNotFoundException
     */
    public function findEntryById(string $id): BlogEntry;

    /**
     * @return BlogEntryCollection
     */
    public function findEntryCollection(): BlogEntryCollection;

    /**
     * @param string $id
     *
     * @return BlogCategoryCollection
     */
    public function findEntryCategoryCollection(string $id): BlogCategoryCollection;
}
