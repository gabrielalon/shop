<?php

namespace Tests\Components\Account\Command;

use App\Components\Account\Application\Command\CreateAdmin\CreateAdmin;
use App\Components\Account\Domain\Valuing\Name;
use App\Components\Account\Infrastructure\Entity\User;
use App\System\Valuing\Char\Text;
use App\System\Valuing\Identity\Uuid;
use Tests\TestCase;

class CreateAdminTest extends TestCase
{
    /**
     * @test
     * @dataProvider adminDataProvider
     *
     * @param Uuid $adminId
     * @param Name $adminName
     * @param Text $adminEmail
     * @param Uuid $adminUserId
     */
    public function itCreatesNewAdmin(Uuid $adminId, Name $adminName, Text $adminEmail, Uuid $adminUserId): void
    {
        // given
        User::factory()->create(['id' => $adminUserId->toString()]);

        // when
        $this->messageBus()->handle(new CreateAdmin(
            $adminId,
            $adminName->firstName(),
            $adminName->lastName(),
            $adminEmail->toString(),
            $adminUserId->toString()
        ));

        // then
        $this->assertDatabaseHas('admin', [
            'id' => $adminId,
            'first_name' => $adminName->firstName(),
            'last_name' => $adminName->lastName(),
            'email' => $adminEmail->toString(),
            'user_id' => $adminUserId->toString(),
        ]);
    }
}
