<?php

namespace App\UI\Web\Account\Admin;

use App\Components\Account\Account;
use App\Components\Site\Site;
use App\System\Illuminate\Service\AuthService;
use App\UI\Web\WebHandler;
use Illuminate\Contracts\Support\Renderable;

class DataShowHandler extends WebHandler
{
    /** @var Site */
    private Site $site;

    /** @var Account */
    private Account $account;

    /** @var AuthService */
    private AuthService $authService;

    /**
     * DataShowHandler constructor.
     *
     * @param Site        $site
     * @param Account     $account
     * @param AuthService $authService
     */
    public function __construct(Site $site, Account $account, AuthService $authService)
    {
        $this->site = $site;
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
        $user = $this->account->askUser()->findUserById($admin->userId());

        return view('admin.account.profile.data-update')->with([
            'user' => $user,
            'admin' => $admin,
            'role_collection' => $this->account->askRole()->findAllRoles(),
            'supported_language_collection' => $this->site->askLanguage()->findAllSupportedLanguages(),
        ]);
    }
}
