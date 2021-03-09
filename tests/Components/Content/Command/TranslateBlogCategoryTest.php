<?php

namespace Tests\Components\Content\Command;

use App\Components\Content\Application\Command\TranslateBlogCategory\TranslateBlogCategory;
use App\Components\Content\Infrastructure\Entity\BlogCategory;
use App\Components\Site\Domain\Enum\LocaleEnum;
use App\System\Valuing\Identity\Uuid;
use App\System\Valuing\Intl\Language\Texts;
use Tests\TestCase;

class TranslateBlogCategoryTest extends TestCase
{
    /**
     * @test
     * @dataProvider blogCategoryDataProvider
     *
     * @param Uuid $categoryId
     */
    public function itRemovesCategory(Uuid $categoryId): void
    {
        // given
        $category = BlogCategory::factory()->create(['id' => $categoryId->toString()]);

        $name = Texts::fromArray([LocaleEnum::EN()->getValue() => 'name en']);

        // when
        $this->messageBus()->handle(new TranslateBlogCategory(
            $category->id,
            $name->raw()
        ));

        // then
        $this->assertDatabaseHas('blog_category_translation', [
            'blog_category_id' => $categoryId->toString(),
            'locale' => LocaleEnum::EN()->getValue(),
            'name' => $name->getLocale(LocaleEnum::EN()->getValue())->toString(),
        ]);
    }
}
