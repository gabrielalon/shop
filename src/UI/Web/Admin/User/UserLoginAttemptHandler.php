<?php

namespace App\UI\Web\Admin\User;

use App\Components\Account\Domain\Enum\RoleEnum;
use App\System\Illuminate\Service\AuthService;
use App\UI\Web\WebHandler;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class UserLoginAttemptHandler extends WebHandler
{
    use ThrottlesLogins;

    /** @var AuthService */
    private AuthService $authService;

    /**
     * LoginAttemptHandler constructor.
     *
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param LoginAttemptRequest $request
     *
     * @return RedirectResponse
     *
     * @throws ValidationException
     */
    public function __invoke(LoginAttemptRequest $request): RedirectResponse
    {
        if (true === $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            $this->sendLockoutResponse($request);
        }

        $auth = $this->authService->withRole(RoleEnum::ADMIN());

        if (false === $auth->login($request->toArray(), $request->filled('remember'))) {
            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
            $this->incrementLoginAttempts($request);

            throw ValidationException::withMessages([$this->username() => [trans('auth.failed')]]);
        }

        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return redirect()->route('admin.account.dashboard');
    }

    /**
     * @return string
     */
    public function username(): string
    {
        return 'email';
    }
}
