<?php

namespace App\Components\Content\Application\Query;

use App\Components\Content\Application\Query\Model\BlogCategoryCollection;
use App\System\Messaging\Query\Query;

interface BlogTreeQuery extends Query
{
    /**
     * @return BlogCategoryCollection
     */
    public function findParentCategoryCollection(): BlogCategoryCollection;

    /**
     * @param string $parentId
     *
     * @return BlogCategoryCollection
     */
    public function findChildrenCategoryCollection(string $parentId): BlogCategoryCollection;
}
