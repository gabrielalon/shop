<?php

namespace App\UI\Web\Admin\Admin;

use App\Components\Account\Account;
use App\System\Illuminate\Service\AuthService;
use App\UI\Web\WebHandler;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Http\RedirectResponse;

class AdminPasswordResetHandler extends WebHandler
{
    /** @var Account */
    private $account;

    /** @var AuthService */
    private $authService;

    /**
     * PasswordResetHandler constructor.
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
     * @param string               $adminId
     * @param PasswordResetRequest $request
     *
     * @return RedirectResponse
     */
    public function __invoke(string $adminId, PasswordResetRequest $request): RedirectResponse
    {
        $admin = $this->account->askAdmin()->findAdminById($adminId);
        $user = $this->account->askUser()->findUserById($admin->userId());

        $this->account->changeUserPassword($user->id(), $request->input('password'));

        if ($admin->isOfUser($this->authService->user())) {
            $this->authService->reload();
        }

        return redirect()->back()
            ->with('success', trans(PasswordBroker::PASSWORD_RESET))
        ;
    }
}
