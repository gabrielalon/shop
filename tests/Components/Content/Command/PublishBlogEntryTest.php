<?php

namespace Tests\Components\Content\Command;

use App\Components\Content\Application\Command\PublishBlogEntry\PublishBlogEntry;
use App\Components\Content\Infrastructure\Entity\BlogEntry;
use App\System\Valuing\Identity\Uuid;
use Carbon\Carbon;
use Tests\TestCase;

class PublishBlogEntryTest extends TestCase
{
    /**
     * @test
     * @dataProvider blogEntryDataProvider
     *
     * @param Uuid $entryId
     */
    public function itRemovesEntry(Uuid $entryId): void
    {
        // given
        $entry = BlogEntry::factory()->create(['id' => $entryId->toString()]);

        $publishAt = Carbon::now();

        // when
        $this->messageBus()->handle(new PublishBlogEntry($entry->id, $publishAt));

        // then
        $this->assertDatabaseHas('blog_entry', [
            'id' => $entryId->toString(),
            'publish_at' => $publishAt->toDateTimeString(),
        ]);
    }
}
