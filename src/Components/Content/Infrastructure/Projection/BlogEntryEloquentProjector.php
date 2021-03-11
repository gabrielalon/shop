<?php

namespace App\Components\Content\Infrastructure\Projection;

use App\Components\Content\Domain\Event;
use App\Components\Content\Domain\Projection\BlogEntryProjection;
use App\Components\Content\Infrastructure\Entity\BlogEntry as EntryEntity;
use App\Components\Site\Domain\Enum\LocaleEnum;

final class BlogEntryEloquentProjector implements BlogEntryProjection
{
    /** @var EntryEntity */
    private EntryEntity $db;

    /**
     * BlogEntryEloquentProjector constructor.
     *
     * @param EntryEntity $db
     */
    public function __construct(EntryEntity $db)
    {
        $this->db = $db;
    }

    /**
     * {@inheritdoc}
     */
    public function onBlogEntryCreated(Event\BlogEntryCreated $event): void
    {
        $this->db->newQuery()->create(['id' => $event->blogEntryId()->toString()]);
    }

    /**
     * {@inheritdoc}
     */
    public function onBlogEntryTranslated(Event\BlogEntryTranslated $event): void
    {
        $data = [];

        foreach (LocaleEnum::values() as $locale) {
            $data[$locale->getValue()] = [
                'name' => $event->blogEntryName()->getLocale($locale->getValue())->toString(),
                'description' => $event->blogEntryDescription()->getLocale($locale->getValue())->toString(),
            ];
        }

        if ($entity = $this->findBlogEntry($event)) {
            $entity->update($data);
        }
    }

    /**
     * @param Event\BlogEntryCategorisedEvent $event
     */
    public function onBlogEntryCategorisedEvent(Event\BlogEntryCategorisedEvent $event): void
    {
        if ($entity = $this->findBlogEntry($event)) {
            $entity->withCategories()->delete();

            foreach ($event->blogEntryCategoryIds()->raw() as $categoryId) {
                $entity->withCategories()->create(['blog_category_id' => $categoryId]);
            }
        }
    }

    /**
     * @param Event\BlogEntryPublished $event
     */
    public function onBlogEntryPublished(Event\BlogEntryPublished $event): void
    {
        if ($entity = $this->findBlogEntry($event)) {
            $entity->update(['publish_at' => $event->blogEntryPublishedAt()->toDateTimeString()]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function onBlogEntryActivated(Event\BlogEntryActivated $event): void
    {
        if ($entity = $this->findBlogEntry($event)) {
            $entity->is_active = $event->blogEntryActive()->raw();
            $entity->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function onBlogEntryDeactivated(Event\BlogEntryDeactivated $event): void
    {
        if ($entity = $this->findBlogEntry($event)) {
            $entity->update(['is_active' => $event->blogEntryActive()->raw()]);
        }
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function onBlogEntryRemoved(Event\BlogEntryRemoved $event): void
    {
        if ($entity = $this->findBlogEntry($event)) {
            $entity->delete();
        }
    }

    /**
     * @param Event\BlogEntryEvent $event
     *
     * @return EntryEntity|null
     */
    public function findBlogEntry(Event\BlogEntryEvent $event): ?EntryEntity
    {
        return $this->db::findByUuid($event->blogEntryId()->toString());
    }
}
