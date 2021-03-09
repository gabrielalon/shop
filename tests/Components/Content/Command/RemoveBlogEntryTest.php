<?php

namespace Tests\Components\Content\Command;

use App\Components\Content\Application\Command\RemoveBlogEntry\RemoveBlogEntry;
use App\Components\Content\Infrastructure\Entity\BlogEntry;
use App\System\Valuing\Identity\Uuid;
use Tests\TestCase;

class RemoveBlogEntryTest extends TestCase
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

        // when
        $this->messageBus()->handle(new RemoveBlogEntry($entry->id));

        // then
        $this->assertSoftDeleted('blog_entry', [
            'id' => $entryId->toString(),
        ]);
    }
}
