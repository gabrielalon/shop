<?php

namespace Database\Factories;

use App\Components\Account\Infrastructure\Entity\User;
use App\Components\Site\Domain\Enum\LocaleEnum;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /** @var string */
    protected $model = User::class;

    /**
     * {@inheritdoc}
     */
    public function definition(): array
    {
        $email = $this->faker->unique()->safeEmail;

        return [
            'id' => $this->faker->uuid,
            'login' => $email,
            'email' => $email,
            'email_verified_at' => now(),
            'password' => app()->get(Hasher::class)->make($this->faker->password),
            'remember_token' => Str::random(10),
            'locale' => LocaleEnum::PL()->getValue(),
        ];
    }
}
