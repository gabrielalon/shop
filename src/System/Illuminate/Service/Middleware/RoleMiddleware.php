<?php

namespace App\System\Illuminate\Service\Middleware;

use App\System\Illuminate\Service\AuthService;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /** @var AuthService */
    private $authService;

    /**
     * RoleMiddleware constructor.
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
    public function handle(Request $request, \Closure $next, string ...$roles)
    {
        if (false === $this->authService->check()) {
            return redirect()->route('admin.login');
        }

        if (false === $request->user()->hasAnyRole($roles)) {
            return redirect()
                ->route('admin.login')
                ->with(['error' => __('validations.invalid_role')])
            ;
        }

        return $next($request);
    }
}
