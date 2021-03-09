<?php

namespace Tests\Components\Content\Command;

use App\Components\Content\Application\Command\RemoveBlogCategory\RemoveBlogCategory;
use App\Components\Content\Infrastructure\Entity\BlogCategory;
use App\System\Valuing\Identity\Uuid;
use Tests\TestCase;

class RemoveBlogCategoryTest extends TestCase
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

        // when
        $this->messageBus()->handle(new RemoveBlogCategory($category->id));

        // then
        $this->assertSoftDeleted('blog_category', [
            'id' => $categoryId->toString(),
        ]);
    }
}
