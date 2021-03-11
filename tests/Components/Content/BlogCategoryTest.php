<?php

namespace Tests\Components\Content;

use App\Components\Content\Domain\BlogCategory;
use App\Components\Content\Domain\Event;
use App\Components\Site\Domain\Enum\LocaleEnum;
use App\System\Messaging\Aggregate\AggregateChanged;
use App\System\Valuing\Identity\Uuid;
use App\System\Valuing\Intl\Language\Texts;
use App\System\Valuing\Number\Number;
use Tests\TestCase;

final class BlogCategoryTest extends TestCase
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

        self::assertCount(1, $events);

        $event = $events[0];
        assert($event instanceof Event\BlogCategoryCreated);

        self::assertSame(Event\BlogCategoryCreated::class, $event->eventName());
        self::assertTrue($categoryId->equals($event->blogCategoryId()));
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

        self::assertCount(1, $events);

        $event = $events[0];
        assert($event instanceof Event\BlogCategoryTranslated);

        self::assertSame(Event\BlogCategoryTranslated::class, $event->eventName());
        self::assertTrue($event->blogCategoryName()->equals($name));
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

        self::assertCount(1, $events);

        $event = $events[0];
        assert($event instanceof Event\BlogCategoryActivated);

        self::assertSame(Event\BlogCategoryActivated::class, $event->eventName());
        self::assertTrue($event->blogCategoryActive()->raw());
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

        self::assertCount(1, $events);

        $event = $events[0];
        assert($event instanceof Event\BlogCategoryDeactivated);

        self::assertSame(Event\BlogCategoryDeactivated::class, $event->eventName());
        self::assertFalse($event->blogCategoryActive()->raw());
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

        self::assertCount(1, $events);

        $event = $events[0];
        assert($event instanceof Event\BlogCategoryPositioned);

        self::assertSame(Event\BlogCategoryPositioned::class, $event->eventName());
        self::assertTrue($event->blogCategoryPosition()->equals($position));
        self::assertNull($event->blogCategoryParentId());
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

        self::assertCount(1, $events);

        $event = $events[0];
        assert($event instanceof Event\BlogCategoryRemoved);

        self::assertSame(Event\BlogCategoryRemoved::class, $event->eventName());
    }

    /**
     * @param AggregateChanged ...$events
     *
     * @return BlogCategory
     */
    private function reconstituteBlogCategoryFromHistory(AggregateChanged ...$events): BlogCategory
    {
        $category = $this->reconstituteAggregateFromHistory(BlogCategory::class, $events);

        assert($category instanceof BlogCategory);

        return $category;
    }

    /**
     * @param Uuid $categoryId
     *
     * @return Event\BlogCategoryCreated
     */
    public function newBlogCategoryCreated(Uuid $categoryId): Event\BlogCategoryCreated
    {
        $event = Event\BlogCategoryCreated::occur($categoryId->toString());

        assert($event instanceof Event\BlogCategoryCreated);

        return $event;
    }
}
