<?php

namespace Tests\Components\Account\Command;

use App\Components\Account\Application\Command\ChangeUserPassword\ChangeUserPassword;
use App\Components\Account\Infrastructure\Entity\User;
use Tests\TestCase;

class ChangeUserPasswordTest extends TestCase
{
    /**
     * @test
     */
    public function itChangesUserPassword(): void
    {
        // given
        /** @var User $user */
        $user = User::factory()->create();
        $password = $this->faker->password;

        // when
        $command = new ChangeUserPassword($user->id, $password);
        $this->messageBus()->handle($command);

        // then
        $this->assertDatabaseHas('user', ['id' => $user->id]);
    }
}
