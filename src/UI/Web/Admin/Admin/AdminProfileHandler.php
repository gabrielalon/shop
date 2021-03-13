<?php

namespace App\UI\Web\Account\Admin;

use App\Components\Account\Account;
use App\System\Illuminate\Service\AuthService;
use App\UI\Web\WebHandler;
use Illuminate\Contracts\Support\Renderable;

class AdminProfileHandler extends WebHandler
{
    /** @var Account */
    private Account $account;

    /** @var AuthService */
    private AuthService $authService;

    /**
     * ProfileHandler constructor.
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
     * @return Renderable
     */
    public function __invoke(): Renderable
    {
        $user = $this->authService->user();
        $admin = $this->account->askAdmin()->findAdminByUserId($user->id());

        return view('admin.account.profile.show')->with([
            'user' => $user,
            'admin' => $admin,
        ]);
    }
}
