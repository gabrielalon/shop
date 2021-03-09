<?php

namespace Tests\Components\Account\Command;

use App\Components\Account\Application\Command\AssignUserRoles\AssignUserRoles;
use App\Components\Account\Domain\Enum\RoleEnum;
use App\Components\Account\Domain\Valuing\Roles;
use App\Components\Account\Infrastructure\Entity\User;
use Tests\TestCase;

class AssignUserRoleTest extends TestCase
{
    /**
     * @test
     */
    public function itAssigneesUserRole(): void
    {
        // given
        /** @var User $user */
        $user = User::factory()->create();
        $roles = Roles::fromRoles([RoleEnum::ADMIN()->getValue()]);

        // when
        $command = new AssignUserRoles($user->id, $roles->roles());
        $this->messageBus()->handle($command);

        // then
        $this->assertDatabaseHas('user_role', [
            'user_id' => $user->id,
            'role_id' => $this->findRoleId(RoleEnum::ADMIN()),
        ]);
    }
}
