<?php

namespace Tests\Components\Account\Query;

use App\Components\Account\Application\Query\Exception\UserNotFoundException;
use App\Components\Account\Domain\Enum\RoleEnum;
use App\Components\Account\Infrastructure\Entity\User;
use App\Components\Account\Infrastructure\Entity\UserRole;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserQueryTest extends TestCase
{
    /**
     * @test
     */
    public function itFindsUserByLoginAndRole(): void
    {
        $role = RoleEnum::ADMIN();

        /** @var User $entity */
        $entity = User::factory()->create();

        UserRole::factory()->create([
            'user_id' => $entity->id,
            'role_id' => $this->findRoleId($role),
        ]);

        $user = $this->account()->askUser()->findUserByLoginAndRole($entity->login, $role);

        $this->assertEquals($entity->id, $user->id());
        $this->assertEquals($entity->login, $user->login());
        $this->assertEquals($entity->locale, $user->locale());
        $this->assertEquals($entity->remember_token, $user->rememberToken());
        $this->assertTrue($user->hasRole($role->getValue()));
    }

    /**
     * @test
     */
    public function itThrowsExceptionOnUserByLoginAndRoleNotFound(): void
    {
        $role = RoleEnum::ADMIN();

        $this->expectException(UserNotFoundException::class);
        $this->account()->askUser()->findUserByLoginAndRole($this->faker->email, $role);
    }

    /**
     * @test
     */
    public function itFindsUserById(): void
    {
        /** @var User $entity */
        $entity = User::factory()->create();

        $user = $this->account()->askUser()->findUserById($entity->id);

        $this->assertEquals($entity->id, $user->id());
        $this->assertEquals($entity->login, $user->login());
        $this->assertEquals($entity->locale, $user->locale());
        $this->assertEquals($entity->remember_token, $user->rememberToken());
    }

    /**
     * @test
     */
    public function itThrowsExceptionOnUserByIdNotFound(): void
    {
        $this->expectException(UserNotFoundException::class);
        $this->account()->askUser()->findUserById($this->faker->uuid);
    }

    /**
     * @test
     */
    public function itFindsUserByIdAndRememberToken(): void
    {
        /** @var User $entity */
        $entity = User::factory()->create();

        $user = $this->account()->askUser()->findUserByIdAndRememberToken($entity->id, $entity->remember_token);

        $this->assertEquals($entity->id, $user->id());
        $this->assertEquals($entity->login, $user->login());
        $this->assertEquals($entity->locale, $user->locale());
        $this->assertEquals($entity->remember_token, $user->rememberToken());
    }

    /**
     * @test
     */
    public function itThrowsExceptionOnUserByIdAndRememberTokenNotFound(): void
    {
        $this->expectException(UserNotFoundException::class);
        $this->account()->askUser()->findUserByIdAndRememberToken($this->faker->uuid, Str::random());
    }
}
