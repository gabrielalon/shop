<?php

namespace App\UI\Web\Admin\Admin;

use App\Components\Account\Account;
use App\UI\Web\WebHandler;
use Illuminate\Contracts\Support\Renderable;

class AdminPasswordResetShowHandler extends WebHandler
{
    /** @var Account */
    private Account $account;

    /**
     * PasswordResetShowHandler constructor.
     *
     * @param Account $account
     */
    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    /**
     * @param string $adminId
     *
     * @return Renderable
     */
    public function __invoke(string $adminId): Renderable
    {
        $admin = $this->account->askAdmin()->findAdminById($adminId);

        return view('admin.account.profile.password-reset')->with([
            'admin' => $admin,
        ]);
    }
}
