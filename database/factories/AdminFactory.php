<?php

namespace Database\Factories;

use App\Components\Account\Infrastructure\Entity\Admin;
use App\Components\Account\Infrastructure\Entity\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdminFactory extends Factory
{
    /** @var string */
    protected $model = Admin::class;

    /**
     * {@inheritdoc}
     */
    public function definition(): array
    {
        $user = User::factory()->create();

        return [
            'id' => $this->faker->uuid,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $user->login,
            'user_id' => $user->id,
        ];
    }
}
