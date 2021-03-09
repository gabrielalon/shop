<?php

namespace Tests\Components\Content\Command;

use App\Components\Content\Application\Command\DeactivateBlogCategory\DeactivateBlogCategory;
use App\Components\Content\Infrastructure\Entity\BlogCategory;
use App\System\Valuing\Identity\Uuid;
use Tests\TestCase;

class DeactivateBlogCategoryTest extends TestCase
{
    /**
     * @test
     * @dataProvider blogCategoryDataProvider
     *
     * @param Uuid $categoryId
     */
    public function itDeactivatesCategory(Uuid $categoryId): void
    {
        // given
        $category = BlogCategory::factory()->create(['id' => $categoryId->toString()]);

        // when
        $this->messageBus()->handle(new DeactivateBlogCategory($category->id));

        // then
        $this->assertDatabaseHas('blog_category', [
            'id' => $categoryId->toString(),
            'is_active' => false,
        ]);
    }
}
