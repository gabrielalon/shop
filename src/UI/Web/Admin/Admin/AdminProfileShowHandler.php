<?php

namespace App\UI\Web\Account\Admin;

use App\Components\Account\Account;
use App\UI\Web\WebHandler;
use Illuminate\Contracts\Support\Renderable;

class AdminProfileShowHandler extends WebHandler
{
    /** @var Account */
    private Account $account;

    /**
     * ProfileShowHandler constructor.
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
        $user = $this->account->askUser()->findUserById($admin->userId());

        return view('admin.account.profile.show')->with([
            'user' => $user,
            'admin' => $admin,
        ]);
    }
}
