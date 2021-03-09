<?php

namespace App\Components\Content\Infrastructure\Persist;

use App\Components\Content\Domain\BlogEntry;
use App\Components\Content\Domain\Persist\BlogEntryRepository;
use App\System\Messaging\Aggregate\AggregateRepository;
use App\System\Valuing\Identity\Uuid;

class BlogEntryAggregateRepository extends AggregateRepository implements BlogEntryRepository
{
    /**
     * {@inheritdoc}
     */
    public function getAggregateRootClass(): string
    {
        return BlogEntry::class;
    }

    /**
     * {@inheritdoc}
     */
    public function find(string $id): BlogEntry
    {
        /** @var BlogEntry $entry */
        $entry = $this->findAggregateRoot(Uuid::fromIdentity($id));

        return $entry;
    }

    /**
     * {@inheritdoc}
     */
    public function save(BlogEntry $entry): void
    {
        $this->saveAggregateRoot($entry);
    }
}
