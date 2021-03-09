<?php

namespace Tests\Components\Account\Command;

use App\Components\Account\Application\Command\ChangeAdminName\ChangeAdminName;
use App\Components\Account\Domain\Valuing\Name;
use App\Components\Account\Infrastructure\Entity\Admin;
use Tests\TestCase;

class ChangeAdminNameTest extends TestCase
{
    /**
     * @test
     */
    public function itChangesAdminName(): void
    {
        // given
        /** @var Admin $admin */
        $admin = Admin::factory()->create();
        $name = Name::fromData($firstName = 'admin', $lastName = 'admin');

        // when
        $command = new ChangeAdminName($admin->id, $name->firstName(), $name->lastName());
        $this->messageBus()->handle($command);

        // then
        $this->assertDatabaseHas('admin', [
            'id' => $admin->id,
            'first_name' => $name->firstName(),
            'last_name' => $name->lastName(),
        ]);
    }
}
