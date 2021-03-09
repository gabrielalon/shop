<?php

namespace Database\Factories;

use App\Components\B2B\Infrastructure\Entity\Contractor;
use App\Components\B2B\Infrastructure\Entity\ContractorAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractorAddressFactory extends Factory
{
    /** @var string */
    protected $model = ContractorAddress::class;

    /**
     * {@inheritdoc}
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid,
            'contractor_id' => Contractor::factory()->create()->id,
            'tax_number' => 3564066352,
            'country_code' => $this->faker->countryCode,
        ];
    }
}
