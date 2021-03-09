<?php

namespace Database\Seeders;

use App\Components\Account\Domain\Enum\RoleEnum;
use App\Components\Account\Infrastructure\Entity\Role;
use App\Components\Site\Domain\Enum\LocaleEnum;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedRoles();
    }

    private function seedRoles(): void
    {
        $condition = ['type' => RoleEnum::ADMIN()];
        Role::query()->updateOrCreate($condition, [
            'level' => 0,
            (string) LocaleEnum::EN() => ['description' => 'Administrator'],
            (string) LocaleEnum::PL() => ['description' => 'Administrator'],
        ]);
    }
}
