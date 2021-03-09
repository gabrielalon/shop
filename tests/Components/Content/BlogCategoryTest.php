<?php

namespace Tests\Components\Content;

use App\Components\Content\Domain\BlogCategory;
use App\Components\Content\Domain\Event;
use App\Components\Site\Domain\Enum\LocaleEnum;
use App\System\Messaging\Aggregate\AggregateChanged;
use App\System\Messaging\Aggregate\AggregateRoot;
use App\System\Valuing\Identity\Uuid;
use App\System\Valuing\Intl\Language\Texts;
use App\System\Valuing\Number\Number;
use Tests\TestCase;

class BlogCategoryTest extends TestCase
{
    /**
     * @test
     * @dataProvider blogCategoryDataProvider
     *
     * @param Uuid $categoryId
     */
    public function itCreatesNewCategory(Uuid $categoryId): void
    {
        $category = BlogCategory::create($categoryId->toString());

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($category);

        $this->assertCount(1, $events);

        /** @var Event\BlogCategoryCreated $event */
        $event = $events[0];

        $this->assertSame(Event\BlogCategoryCreated::class, $event->eventName());
        $this->assertTrue($categoryId->equals($event->blogCategoryId()));
    }

    /**
     * @test
     * @dataProvider blogCategoryDataProvider
     *
     * @param Uuid $categoryId
     */
    public function itTranslatesCategory(Uuid $categoryId): void
    {
        $category = $this->reconstituteBlogCategoryFromHistory($this->newBlogCategoryCreated(
            $categoryId
        ));

        $name = Texts::fromArray([LocaleEnum::EN()->getValue() => 'name en']);

        $category->translate($name->raw());

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($category);

        $this->assertCount(1, $events);

        /** @var Event\BlogCategoryTranslated $event */
        $event = $events[0];

        $this->assertSame(Event\BlogCategoryTranslated::class, $event->eventName());
        $this->assertTrue($event->blogCategoryName()->equals($name));
    }

    /**
     * @test
     * @dataProvider blogCategoryDataProvider
     *
     * @param Uuid $categoryId
     */
    public function itActivatesCategory(Uuid $categoryId): void
    {
        $category = $this->reconstituteBlogCategoryFromHistory($this->newBlogCategoryCreated(
            $categoryId
        ));

        $category->activate();

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($category);

        $this->assertCount(1, $events);

        /** @var Event\BlogCategoryActivated $event */
        $event = $events[0];

        $this->assertSame(Event\BlogCategoryActivated::class, $event->eventName());
        $this->assertTrue($event->blogCategoryActive()->raw());
    }

    /**
     * @test
     * @dataProvider blogCategoryDataProvider
     *
     * @param Uuid $categoryId
     */
    public function itDeactivatesCategory(Uuid $categoryId): void
    {
        $category = $this->reconstituteBlogCategoryFromHistory($this->newBlogCategoryCreated(
            $categoryId
        ));

        $category->deactivate();

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($category);

        $this->assertCount(1, $events);

        /** @var Event\BlogCategoryDeactivated $event */
        $event = $events[0];

        $this->assertSame(Event\BlogCategoryDeactivated::class, $event->eventName());
        $this->assertFalse($event->blogCategoryActive()->raw());
    }

    /**
     * @test
     * @dataProvider blogCategoryDataProvider
     *
     * @param Uuid $categoryId
     */
    public function itPositionsCategory(Uuid $categoryId): void
    {
        $category = $this->reconstituteBlogCategoryFromHistory($this->newBlogCategoryCreated(
            $categoryId
        ));

        $position = Number::fromInt(10);

        $category->position($position->raw());

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($category);

        $this->assertCount(1, $events);

        /** @var Event\BlogCategoryPositioned $event */
        $event = $events[0];

        $this->assertSame(Event\BlogCategoryPositioned::class, $event->eventName());
        $this->assertTrue($event->blogCategoryPosition()->equals($position));
        $this->assertNull($event->blogCategoryParentId());
    }

    /**
     * @test
     * @dataProvider blogCategoryDataProvider
     *
     * @param Uuid $categoryId
     */
    public function itRemovesCategory(Uuid $categoryId): void
    {
        $category = $this->reconstituteBlogCategoryFromHistory($this->newBlogCategoryCreated(
            $categoryId
        ));

        $category->remove();

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($category);

        $this->assertCount(1, $events);

        /** @var Event\BlogCategoryRemoved $event */
        $event = $events[0];

        $this->assertSame(Event\BlogCategoryRemoved::class, $event->eventName());
    }

    /**
     * @param AggregateChanged ...$events
     *
     * @return AggregateRoot|BlogCategory
     */
    private function reconstituteBlogCategoryFromHistory(AggregateChanged ...$events): AggregateRoot
    {
        return $this->reconstituteAggregateFromHistory(BlogCategory::class, $events);
    }

    /**
     * @param Uuid $categoryId
     *
     * @return Event\BlogCategoryCreated
     */
    public function newBlogCategoryCreated(Uuid $categoryId): Event\BlogCategoryCreated
    {
        return Event\BlogCategoryCreated::occur($categoryId->toString());
    }
}
