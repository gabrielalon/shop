<?php

namespace App\Components\Content\Infrastructure\Persist;

use App\Components\Content\Domain\BlogCategory;
use App\Components\Content\Domain\Persist\BlogCategoryRepository;
use App\System\Messaging\Aggregate\AggregateRepository;
use App\System\Valuing\Identity\Uuid;

class BlogCategoryAggregateRepository extends AggregateRepository implements BlogCategoryRepository
{
    /**
     * {@inheritdoc}
     */
    public function getAggregateRootClass(): string
    {
        return BlogCategory::class;
    }

    /**
     * {@inheritdoc}
     */
    public function find(string $id): BlogCategory
    {
        /** @var BlogCategory $entry */
        $entry = $this->findAggregateRoot(Uuid::fromIdentity($id));

        return $entry;
    }

    /**
     * {@inheritdoc}
     */
    public function save(BlogCategory $entry): void
    {
        $this->saveAggregateRoot($entry);
    }
}
