<?php

namespace App\UI\Cli\Account;

use App\Components\Account\Account;
use App\Components\Site\Domain\Enum\LocaleEnum;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class AdminRegisterCommand extends Command
{
    /** @var string */
    protected $signature = 'app:admin-register {firstName} {lastName} {email}';

    /** @var string */
    protected $description = 'Registers admin user
                              {firstName : Admin first name}
                              {lastName : Admin last name}
                              {email: Admin email address}';

    /**
     * @param Account $account
     */
    public function handle(Account $account): void
    {
        try {
            $adminId = $account->createAdmin(
                (string) $this->argument('firstName'),
                (string) $this->argument('lastName'),
                (string) $this->argument('email'),
                $password = Str::random(),
                LocaleEnum::PL()->getValue()
            );

            $admin = $account->askAdmin()->findAdminById($adminId);

            $this->info(sprintf('Admin %s registered. Password: %s', $admin->email(), $password));
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }
}
