<?php

namespace Tests\Components\Content\Command;

use App\Components\Content\Application\Command\PositionBlogCategory\PositionBlogCategory;
use App\Components\Content\Infrastructure\Entity\BlogCategory;
use App\System\Valuing\Identity\Uuid;
use App\System\Valuing\Number\Number;
use Tests\TestCase;

class PositionBlogCategoryTest extends TestCase
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
        $position = Number::fromInt(10);

        // when
        $this->messageBus()->handle(new PositionBlogCategory($category->id, $position->raw()));

        // then
        $this->assertDatabaseHas('blog_category', [
            'id' => $categoryId->toString(),
            'position' => $position->raw(),
        ]);
    }
}
