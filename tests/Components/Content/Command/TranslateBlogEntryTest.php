<?php

namespace Tests\Components\Content\Command;

use App\Components\Content\Application\Command\TranslateBlogEntry\TranslateBlogEntry;
use App\Components\Content\Infrastructure\Entity\BlogEntry;
use App\Components\Site\Domain\Enum\LocaleEnum;
use App\System\Valuing\Identity\Uuid;
use App\System\Valuing\Intl\Language\Contents;
use App\System\Valuing\Intl\Language\Texts;
use Tests\TestCase;

class TranslateBlogEntryTest extends TestCase
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

        $name = Texts::fromArray([LocaleEnum::EN()->getValue() => 'name en']);
        $description = Contents::fromArray([LocaleEnum::EN()->getValue() => 'desc en']);

        // when
        $this->messageBus()->handle(new TranslateBlogEntry(
            $entry->id,
            $name->raw(),
            $description->raw()
        ));

        // then
        $this->assertDatabaseHas('blog_entry_translation', [
            'blog_entry_id' => $entryId->toString(),
            'locale' => LocaleEnum::EN()->getValue(),
            'name' => $name->getLocale(LocaleEnum::EN()->getValue())->toString(),
            'description' => $description->getLocale(LocaleEnum::EN()->getValue())->toString(),
        ]);
    }
}
