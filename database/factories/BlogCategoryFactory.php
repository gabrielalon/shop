<?php

namespace Database\Factories;

use App\Components\Content\Infrastructure\Entity\BlogCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogCategoryFactory extends Factory
{
    /** @var string */
    protected $model = BlogCategory::class;

    /**
     * {@inheritdoc}
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid,
            'is_active' => true,
        ];
    }
}
