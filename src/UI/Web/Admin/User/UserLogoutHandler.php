<?php

namespace App\UI\Web\Account\Admin;

use App\System\Illuminate\Service\AuthService;
use App\UI\Web\WebHandler;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserLogoutHandler extends WebHandler
{
    use ThrottlesLogins;

    /** @var AuthService */
    private $authService;

    /**
     * LogoutHandler constructor.
     *
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $locale = $this->authService->user()->locale();

        $this->authService->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with(['locale' => $locale]);
    }
}
