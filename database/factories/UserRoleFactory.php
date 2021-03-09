<?php

namespace Database\Factories;

use App\Components\Account\Infrastructure\Entity\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserRoleFactory extends Factory
{
    /** @var string */
    protected $model = UserRole::class;

    /**
     * {@inheritdoc}
     */
    public function definition()
    {
        return [];
    }
}
