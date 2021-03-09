<?php

namespace Database\Factories;

use App\Components\Content\Infrastructure\Entity\BlogEntry;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogEntryFactory extends Factory
{
    /** @var string */
    protected $model = BlogEntry::class;

    /**
     * {@inheritdoc}
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid,
            'is_active' => true,
            'publish_at' => Carbon::now()->toDateTimeString(),
        ];
    }
}
