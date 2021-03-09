<?php

namespace Database\Factories;

use App\Components\B2B\Infrastructure\Entity\Contractor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractorFactory extends Factory
{
    /** @var string */
    protected $model = Contractor::class;

    /**
     * {@inheritdoc}
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid,
            'name' => $this->faker->name,
        ];
    }
}
