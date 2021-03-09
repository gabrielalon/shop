<?php

namespace App\Components\Content\Application\Query\Model;

class BlogCategoryCollection extends \ArrayIterator
{
    /**
     * @param BlogCategory $category
     */
    public function add(BlogCategory $category): void
    {
        $this->offsetSet($category->id(), $category);
    }

    /**
     * @param BlogCategoryCollection $collection
     *
     * @return BlogCategoryCollection
     */
    public function merge(BlogCategoryCollection $collection): BlogCategoryCollection
    {
        foreach ($collection->all() as $category) {
            $this->add($category);
        }

        return $this;
    }

    /**
     * @return BlogCategory[]
     */
    public function all(): array
    {
        return $this->getArrayCopy();
    }
}
