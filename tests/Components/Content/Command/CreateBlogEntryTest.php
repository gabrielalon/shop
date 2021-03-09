<?php

namespace Tests\Components\Content\Command;

use App\Components\Content\Application\Command\CreateBlogEntry\CreateBlogEntry;
use App\System\Valuing\Identity\Uuid;
use Tests\TestCase;

class CreateBlogEntryTest extends TestCase
{
    /**
     * @test
     * @dataProvider blogEntryDataProvider
     *
     * @param Uuid $entryId
     */
    public function itCreatesEntry(Uuid $entryId): void
    {
        // when
        $this->messageBus()->handle(new CreateBlogEntry($entryId->toString()));

        // then
        $this->assertDatabaseHas('blog_entry', [
            'id' => $entryId->toString(),
        ]);
    }
}
