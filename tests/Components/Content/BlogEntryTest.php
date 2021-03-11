<?php

namespace Tests\Components\Content;

use App\Components\Content\Domain\BlogEntry;
use App\Components\Content\Domain\Event;
use App\Components\Site\Domain\Enum\LocaleEnum;
use App\System\Messaging\Aggregate\AggregateChanged;
use App\System\Valuing\Identity\Uuid;
use App\System\Valuing\Identity\Uuids;
use App\System\Valuing\Intl\Language\Contents;
use App\System\Valuing\Intl\Language\Texts;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Tests\TestCase;

final class BlogEntryTest extends TestCase
{
    /**
     * @test
     * @dataProvider blogEntryDataProvider
     *
     * @param Uuid $entryId
     */
    public function itCreatesNewEntry(Uuid $entryId): void
    {
        $entry = BlogEntry::create($entryId->toString());

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($entry);

        self::assertCount(1, $events);

        $event = $events[0];
        assert($event instanceof Event\BlogEntryCreated);

        self::assertSame(Event\BlogEntryCreated::class, $event->eventName());
        self::assertTrue($entryId->equals($event->blogEntryId()));
    }

    /**
     * @test
     * @dataProvider blogEntryDataProvider
     *
     * @param Uuid $entryId
     */
    public function itTranslatesEntry(Uuid $entryId): void
    {
        $entry = $this->reconstituteBlogEntryFromHistory($this->newBlogEntryCreated(
            $entryId
        ));

        $name = Texts::fromArray([LocaleEnum::EN()->getValue() => 'name en']);
        $description = Contents::fromArray([LocaleEnum::EN()->getValue() => 'desc en']);

        $entry->translate($name->raw(), $description->raw());

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($entry);

        self::assertCount(1, $events);

        $event = $events[0];
        assert($event instanceof Event\BlogEntryTranslated);

        self::assertSame(Event\BlogEntryTranslated::class, $event->eventName());
        self::assertTrue($event->blogEntryName()->equals($name));
        self::assertTrue($event->blogEntryDescription()->equals($description));
    }

    /**
     * @test
     * @dataProvider blogEntryDataProvider
     *
     * @param Uuid $entryId
     */
    public function itPublishesEntry(Uuid $entryId): void
    {
        $entry = $this->reconstituteBlogEntryFromHistory($this->newBlogEntryCreated(
            $entryId
        ));

        $publishAt = Carbon::now();

        $entry->publish($publishAt);

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($entry);

        self::assertCount(1, $events);

        $event = $events[0];
        assert($event instanceof Event\BlogEntryPublished);

        self::assertSame(Event\BlogEntryPublished::class, $event->eventName());
    }

    /**
     * @test
     * @dataProvider blogEntryDataProvider
     *
     * @param Uuid $entryId
     */
    public function itCategorisesEntry(Uuid $entryId): void
    {
        $entry = $this->reconstituteBlogEntryFromHistory($this->newBlogEntryCreated(
            $entryId
        ));

        $categoriesID = Uuids::fromArray([Str::uuid()->toString()]);

        $entry->categorise($categoriesID->toArray());

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($entry);

        self::assertCount(1, $events);

        $event = $events[0];
        assert($event instanceof Event\BlogEntryCategorisedEvent);

        self::assertSame(Event\BlogEntryCategorisedEvent::class, $event->eventName());
        self::assertTrue($event->blogEntryCategoryIds()->equals($categoriesID));
    }

    /**
     * @test
     * @dataProvider blogEntryDataProvider
     *
     * @param Uuid $entryId
     */
    public function itActivatesEntry(Uuid $entryId): void
    {
        $entry = $this->reconstituteBlogEntryFromHistory($this->newBlogEntryCreated(
            $entryId
        ));

        $entry->activate();

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($entry);

        self::assertCount(1, $events);

        $event = $events[0];
        assert($event instanceof Event\BlogEntryActivated);

        self::assertSame(Event\BlogEntryActivated::class, $event->eventName());
        self::assertTrue($event->blogEntryActive()->raw());
    }

    /**
     * @test
     * @dataProvider blogEntryDataProvider
     *
     * @param Uuid $entryId
     */
    public function itDeactivatesEntry(Uuid $entryId): void
    {
        $entry = $this->reconstituteBlogEntryFromHistory($this->newBlogEntryCreated(
            $entryId
        ));

        $entry->deactivate();

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($entry);

        self::assertCount(1, $events);

        $event = $events[0];
        assert($event instanceof Event\BlogEntryDeactivated);

        self::assertSame(Event\BlogEntryDeactivated::class, $event->eventName());
        self::assertFalse($event->blogEntryActive()->raw());
    }

    /**
     * @test
     * @dataProvider blogEntryDataProvider
     *
     * @param Uuid $entryId
     */
    public function itRemovesEntry(Uuid $entryId): void
    {
        $entry = $this->reconstituteBlogEntryFromHistory($this->newBlogEntryCreated(
            $entryId
        ));

        $entry->remove();

        /** @var AggregateChanged[] $events */
        $events = $this->popRecordedEvents($entry);

        self::assertCount(1, $events);

        $event = $events[0];
        assert($event instanceof Event\BlogEntryRemoved);

        self::assertSame(Event\BlogEntryRemoved::class, $event->eventName());
    }

    /**
     * @param AggregateChanged ...$events
     *
     * @return BlogEntry
     */
    private function reconstituteBlogEntryFromHistory(AggregateChanged ...$events): BlogEntry
    {
        $entry = $this->reconstituteAggregateFromHistory(BlogEntry::class, $events);

        assert($entry instanceof BlogEntry);

        return $entry;
    }

    /**
     * @param Uuid $entryId
     *
     * @return Event\BlogEntryCreated
     */
    public function newBlogEntryCreated(Uuid $entryId): Event\BlogEntryCreated
    {
        $event = Event\BlogEntryCreated::occur($entryId->toString());

        assert($event instanceof Event\BlogEntryCreated);

        return $event;
    }
}
