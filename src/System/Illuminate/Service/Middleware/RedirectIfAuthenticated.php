<?php

namespace App\System\Illuminate\Service\Middleware;

use App\System\Illuminate\Service\AuthService;
use Closure;
use Illuminate\Http\Request;

class RedirectIfAuthenticated
{
    /** @var AuthService */
    private $authService;

    /**
     * RedirectIfAuthenticated constructor.
     *
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param Request  $request
     * @param \Closure $next
     * @param string   ...$roles
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        if (true === $this->authService->check() && true === $this->authService->user()->hasAnyRole($roles)) {
            return redirect()->route('admin.account.dashboard');
        }

        return $next($request);
    }
}
