<?php

namespace Tests\Components\Account\Command;

use App\Components\Account\Application\Command\RefreshUserRememberToken\RefreshUserRememberToken;
use App\Components\Account\Infrastructure\Entity\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class RefreshUserRememberTokenTest extends TestCase
{
    /**
     * @test
     */
    public function itRefreshesUserRememberToken(): void
    {
        // given
        /** @var User $user */
        $user = User::factory()->create();
        $token = Str::random();

        // when
        $this->messageBus()->handle(new RefreshUserRememberToken($user->id, $token));

        // then
        $this->assertDatabaseHas('user', ['id' => $user->id, 'remember_token' => $token]);
    }
}
