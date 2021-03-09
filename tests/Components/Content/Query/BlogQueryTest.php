<?php

namespace Tests\Components\Content\Query;

use App\Components\Content\Application\Query\Exception\BlogCategoryNotFoundException;
use App\Components\Content\Application\Query\Exception\BlogEntryNotFoundException;
use App\Components\Content\Infrastructure\Entity\BlogCategory;
use App\Components\Content\Infrastructure\Entity\BlogEntry;
use Tests\TestCase;

class BlogQueryTest extends TestCase
{
    /**
     * @test
     */
    public function itFindsCategoryById(): void
    {
        /** @var BlogCategory $entity */
        $entity = BlogCategory::factory()->create();

        $category = $this->content()->askBlog()->findCategoryById($entity->id);

        $this->assertEquals($entity->id, $category->id());
    }

    /**
     * @test
     */
    public function itThrowsExceptionOnCategoryByIdNotFound(): void
    {
        $this->expectException(BlogCategoryNotFoundException::class);
        $this->content()->askBlog()->findCategoryById($this->faker->uuid);
    }

    /**
     * @test
     */
    public function itFindsEntryById(): void
    {
        /** @var BlogEntry $entity */
        $entity = BlogEntry::factory()->create();

        $entry = $this->content()->askBlog()->findEntryById($entity->id);

        $this->assertEquals($entity->id, $entry->id());
    }

    /**
     * @test
     */
    public function itThrowsExceptionOnEntryByIdNotFound(): void
    {
        $this->expectException(BlogEntryNotFoundException::class);
        $this->content()->askBlog()->findEntryById($this->faker->uuid);
    }
}
