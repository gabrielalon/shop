<?php

namespace Database\Factories;

use App\Components\Account\Infrastructure\Entity\User;
use App\Components\B2B\Infrastructure\Entity\Contractor;
use App\Components\B2B\Infrastructure\Entity\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /** @var string */
    protected $model = Customer::class;

    /**
     * {@inheritdoc}
     */
    public function definition(): array
    {
        $user = User::factory()->create();
        $contractor = Contractor::factory()->create();

        return [
            'id' => $this->faker->uuid,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $user->login,
            'contractor_id' => $contractor->id,
            'user_id' => $user->id,
        ];
    }
}
