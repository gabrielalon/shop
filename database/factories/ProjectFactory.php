<?php

namespace Database\Factories;

use App\Components\B2B\Infrastructure\Entity\Contractor;
use App\Components\B2B\Infrastructure\Entity\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /** @var string */
    protected $model = Project::class;

    /**
     * {@inheritdoc}
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid,
            'contractor_id' => Contractor::factory()->create()->id,
            'name' => $this->faker->name,
            'note' => $this->faker->text,
        ];
    }
}
