<?php

namespace Tests\Components\Content\Command;

use App\Components\Content\Application\Command\ActivateBlogEntry\ActivateBlogEntry;
use App\Components\Content\Infrastructure\Entity\BlogEntry;
use App\System\Valuing\Identity\Uuid;
use Tests\TestCase;

class ActivateBlogEntryTest extends TestCase
{
    /**
     * @test
     * @dataProvider blogEntryDataProvider
     *
     * @param Uuid $entryId
     */
    public function itActivatesEntry(Uuid $entryId): void
    {
        // given
        $entry = BlogEntry::factory()->create(['id' => $entryId->toString()]);

        // when
        $this->messageBus()->handle(new ActivateBlogEntry($entry->id));

        // then
        $this->assertDatabaseHas('blog_entry', [
            'id' => $entryId->toString(),
            'is_active' => true,
        ]);
    }
}
