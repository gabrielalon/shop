<?php

namespace Database\Seeders;

use App\Components\Account\Domain\Enum\RoleEnum;
use App\Components\Account\Domain\Enum\StateEnum;
use App\Components\Account\Infrastructure\Entity\Role;
use App\Components\Account\Infrastructure\Entity\State;
use App\Components\Site\Domain\Enum\LocaleEnum;
use Illuminate\Database\Seeder;

final class AccountSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedStates();
        $this->seedRoles();
    }

    private function seedStates(): void
    {
        foreach (StateEnum::values() as $state) {
            State::query()->updateOrCreate(['type' => $state->getValue()], [
                LocaleEnum::EN()->getValue() => ['description' => $state->getValue()],
                LocaleEnum::PL()->getValue() => ['description' => $state->getValue()],
            ]);
        }
    }

    private function seedRoles(): void
    {
        foreach (RoleEnum::values() as $role) {
            Role::query()->updateOrCreate(['type' => $role->getValue()], [
                'level' => 0,
                LocaleEnum::EN()->getValue() => ['description' => $role->getValue()],
                LocaleEnum::PL()->getValue() => ['description' => $role->getValue()],
            ]);
        }
    }
}
