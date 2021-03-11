<?php

namespace Tests\Components\Account\Command;

use App\Components\Account\Application\Command\CreateAdmin\CreateAdmin;
use App\Components\Account\Domain\Valuing\Name;
use App\System\Valuing\Char\Text;
use App\System\Valuing\Identity\Uuid;
use Tests\TestCase;

final class CreateAdminTest extends TestCase
{
    /**
     * @test
     * @dataProvider adminDataProvider
     *
     * @param Uuid $adminId
     * @param Name $adminName
     * @param Text $adminEmail
     * @param Text $adminPassword
     */
    public function itCreatesNewAdmin(Uuid $adminId, Name $adminName, Text $adminEmail, Text $adminPassword): void
    {
        // when
        $this->messageBus()->handle(new CreateAdmin(
            $adminId,
            $adminName->firstName(),
            $adminName->lastName(),
            $adminEmail->toString(),
            $adminPassword->toString()
        ));

        // then
        $this->assertDatabaseHas('admin', [
            'id' => $adminId,
            'first_name' => $adminName->firstName(),
            'last_name' => $adminName->lastName(),
        ]);
    }
}
