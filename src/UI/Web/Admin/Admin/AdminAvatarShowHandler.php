<?php

namespace App\UI\Web\Account\Admin;

use App\Components\Account\Account;
use App\System\Illuminate\Service\AuthService;
use App\UI\Web\WebHandler;
use Illuminate\Contracts\Support\Renderable;

class AdminAvatarShowHandler extends WebHandler
{
    /** @var Account */
    private Account $account;

    /** @var AuthService */
    private AuthService $authService;

    /**
     * AvatarShowHandler constructor.
     *
     * @param Account     $account
     * @param AuthService $authService
     */
    public function __construct(Account $account, AuthService $authService)
    {
        $this->account = $account;
        $this->authService = $authService;
    }

    /**
     * @param string $adminId
     *
     * @return Renderable
     */
    public function __invoke(string $adminId): Renderable
    {
        $admin = $this->account->askAdmin()->findAdminById($adminId);

        return view('admin.account.profile.avatar-change')->with([
            'user' => $this->authService->user(),
            'admin' => $admin,
        ]);
    }
}
