<?php

namespace App\Components\Content\Infrastructure\Projection;

use App\Components\Content\Domain\Event;
use App\Components\Content\Domain\Projection\BlogCategoryProjection;
use App\Components\Content\Infrastructure\Entity\BlogCategory as CategoryEntity;
use App\Components\Site\Domain\Enum\LocaleEnum;

final class BlogCategoryEloquentProjector implements BlogCategoryProjection
{
    /** @var CategoryEntity */
    private CategoryEntity $db;

    /**
     * BlogCategoryEloquentProjector constructor.
     *
     * @param CategoryEntity $db
     */
    public function __construct(CategoryEntity $db)
    {
        $this->db = $db;
    }

    /**
     * {@inheritdoc}
     */
    public function onBlogCategoryCreated(Event\BlogCategoryCreated $event): void
    {
        $this->db->newQuery()->create(['id' => $event->blogCategoryId()->toString()]);
    }

    /**
     * {@inheritdoc}
     */
    public function onBlogCategoryTranslated(Event\BlogCategoryTranslated $event): void
    {
        $data = [];

        foreach (LocaleEnum::values() as $locale) {
            $data[$locale->getValue()] = [
                'name' => $event->blogCategoryName()->getLocale($locale->getValue())->toString(),
            ];
        }

        if ($entity = $this->findBlogCategory($event)) {
            $entity->update($data);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function onBlogCategoryActivated(Event\BlogCategoryActivated $event): void
    {
        if ($entity = $this->findBlogCategory($event)) {
            $entity->update(['is_active' => $event->blogCategoryActive()->raw()]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function onBlogCategoryDeactivated(Event\BlogCategoryDeactivated $event): void
    {
        if ($entity = $this->findBlogCategory($event)) {
            $entity->update(['is_active' => $event->blogCategoryActive()->raw()]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function onBlogCategoryPositioned(Event\BlogCategoryPositioned $event): void
    {
        if ($entity = $this->findBlogCategory($event)) {
            $entity->update(['position' => $event->blogCategoryPosition()->raw()]);

            $entity->update(['parent_id' => null]);
            if ($parentId = $event->blogCategoryParentId()) {
                $entity->update(['parent_id' => $parentId->toString()]);
            }
        }
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function onBlogCategoryRemoved(Event\BlogCategoryRemoved $event): void
    {
        if ($entity = $this->findBlogCategory($event)) {
            $entity->remove();
        }
    }

    /**
     * @param Event\BlogCategoryEvent $event
     *
     * @return CategoryEntity|null
     */
    public function findBlogCategory(Event\BlogCategoryEvent $event): ?CategoryEntity
    {
        return $this->db::findByUuid($event->blogCategoryId()->toString());
    }
}
