<?php

namespace Tests\Components\Content\Command;

use App\Components\Content\Application\Command\CategoriseBlogEntry\CategoriseBlogEntry;
use App\Components\Content\Infrastructure\Entity\BlogCategory;
use App\Components\Content\Infrastructure\Entity\BlogEntry;
use App\System\Valuing\Identity\Uuid;
use App\System\Valuing\Identity\Uuids;
use Tests\TestCase;

class CategoriseBlogEntryTest extends TestCase
{
    /**
     * @test
     * @dataProvider blogEntryDataProvider
     *
     * @param Uuid $entryId
     */
    public function itCategorisesEntry(Uuid $entryId): void
    {
        // given
        $entry = BlogEntry::factory()->create(['id' => $entryId->toString()]);
        $category = BlogCategory::factory()->create();

        $categoriesID = Uuids::fromArray([$category->id]);

        // when
        $this->messageBus()->handle(new CategoriseBlogEntry($entry->id, $categoriesID->toArray()));

        // then
        $this->assertDatabaseHas('blog_entry_with_category', [
            'blog_entry_id' => $entryId->toString(),
            'blog_category_id' => $category->id,
        ]);
    }
}
