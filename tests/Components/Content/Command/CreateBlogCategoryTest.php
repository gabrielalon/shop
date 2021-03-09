<?php

namespace Tests\Components\Content\Command;

use App\Components\Content\Application\Command\CreateBlogCategory\CreateBlogCategory;
use App\System\Valuing\Identity\Uuid;
use Tests\TestCase;

class CreateBlogCategoryTest extends TestCase
{
    /**
     * @test
     * @dataProvider blogCategoryDataProvider
     *
     * @param Uuid $categoryId
     */
    public function itCreatesCategory(Uuid $categoryId): void
    {
        // when
        $this->messageBus()->handle(new CreateBlogCategory($categoryId->toString()));

        // then
        $this->assertDatabaseHas('blog_category', [
            'id' => $categoryId->toString(),
        ]);
    }
}
