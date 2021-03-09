<?php

namespace Tests\Components\Account\Command;

use App\Components\Account\Application\Command\CreateUser\CreateUser;
use App\System\Valuing\Char\Text;
use App\System\Valuing\Identity\Uuid;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    /**
     * @test
     * @dataProvider userDataProvider
     *
     * @param Uuid $userId
     * @param Text $userLogin
     * @param Text $userPassword
     */
    public function itCreatedNewUser(Uuid $userId, Text $userLogin, Text $userPassword): void
    {
        // when
        $this->messageBus()->handle(new CreateUser($userId, $userLogin, $userPassword));

        $this->assertDatabaseHas('user', ['id' => $userId, 'login' => $userLogin]);
    }
}
