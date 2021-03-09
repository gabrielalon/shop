<?php

namespace Tests\Components\Account;

use App\Components\Account\Account;
use App\Components\Account\Domain\Enum\RoleEnum;
use App\Components\Account\Domain\Valuing\Name;
use App\Components\Account\Infrastructure\Entity\Role;
use App\System\Valuing\Char\Text;
use App\System\Valuing\Identity\Uuid;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Support\Str;

trait AccountContext
{
    /**
     * @return array[]
     */
    public function adminDataProvider(): array
    {
        return [[
            Uuid::fromIdentity(Str::uuid()->toString()),
            Name::fromData('firstName', 'lastName'),
            Text::fromString('email@email.test'),
            Uuid::fromIdentity(Str::uuid()->toString()),
        ]];
    }

    /**
     * @return array[]
     */
    public function userDataProvider(): array
    {
        return [[
            Uuid::fromIdentity(Str::uuid()->toString()),
            Text::fromString('email@email.test'),
            Text::fromString('password-test'),
        ]];
    }

    /**
     * @return Account
     */
    public function account(): Account
    {
        return $this->app->get(Account::class);
    }

    /**
     * @return Hasher
     */
    protected function passwordHasher(): Hasher
    {
        return $this->app->get(Hasher::class);
    }

    /**
     * @param RoleEnum $role
     *
     * @return string
     */
    public function findRoleId(RoleEnum $role): string
    {
        return Role::query()->where(['type' => $role->getValue()])->pluck('id')->get(0);
    }
}
