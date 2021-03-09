<?php

namespace Tests\Components\Content;

use App\Components\Content\Domain\BlogEntry;
use App\Components\Content\Domain\Event;
use App\Components\Site\Domain\Enum\LocaleEnum;
use App\System\Messaging\Aggregate\AggregateChanged;
use App\System\Messaging\Aggregate\AggregateRoot;
use App\System\Valuing\Identity\Uuid;
use App\System\Valuing\Identity\Uuids;
use App\System\Valuing\Intl\Language\Contents;
use App\System\Valuing\Intl\Language\Texts;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Tests\TestCase;

class BlogEntryTest extends TestCase
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

        $this->assertCount(1, $events);

        /** @var Event\BlogEntryCreated $event */
        $event = $events[0];

        $this->assertSame(Event\BlogEntryCreated::class, $event->eventName());
        $this->assertTrue($entryId->equals($event->blogEntryId()));
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

        $this->assertCount(1, $events);

        /** @var Event\BlogEntryTranslated $event */
        $event = $events[0];

        $this->assertSame(Event\BlogEntryTranslated::class, $event->eventName());
        $this->assertTrue($event->blogEntryName()->equals($name));
        $this->assertTrue($event->blogEntryDescription()->equals($description));
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

        $this->assertCount(1, $events);

        /** @var Event\BlogEntryPublished $event */
        $event = $events[0];

        $this->assertSame(Event\BlogEntryPublished::class, $event->eventName());
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

        $this->assertCount(1, $events);

        /** @var Event\BlogEntryCategorisedEvent $event */
        $event = $events[0];

        $this->assertSame(Event\BlogEntryCategorisedEvent::class, $event->eventName());
        $this->assertTrue($event->blogEntryCategoryIds()->equals($categoriesID));
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

        $this->assertCount(1, $events);

        /** @var Event\BlogEntryActivated $event */
        $event = $events[0];

        $this->assertSame(Event\BlogEntryActivated::class, $event->eventName());
        $this->assertTrue($event->blogEntryActive()->raw());
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

        $this->assertCount(1, $events);

        /** @var Event\BlogEntryDeactivated $event */
        $event = $events[0];

        $this->assertSame(Event\BlogEntryDeactivated::class, $event->eventName());
        $this->assertFalse($event->blogEntryActive()->raw());
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

        $this->assertCount(1, $events);

        /** @var Event\BlogEntryRemoved $event */
        $event = $events[0];

        $this->assertSame(Event\BlogEntryRemoved::class, $event->eventName());
    }

    /**
     * @param AggregateChanged ...$events
     *
     * @return AggregateRoot|BlogEntry
     */
    private function reconstituteBlogEntryFromHistory(AggregateChanged ...$events): AggregateRoot
    {
        return $this->reconstituteAggregateFromHistory(BlogEntry::class, $events);
    }

    /**
     * @param Uuid $entryId
     *
     * @return Event\BlogEntryCreated
     */
    public function newBlogEntryCreated(Uuid $entryId): Event\BlogEntryCreated
    {
        return Event\BlogEntryCreated::occur($entryId->toString());
    }
}
