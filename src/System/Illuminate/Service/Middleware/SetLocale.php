<?php

namespace App\System\Illuminate\Service\Middleware;

use App\System\Illuminate\Service\AuthService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class SetLocale
{
    /** @var AuthService */
    private $authService;

    /**
     * SetLocale constructor.
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
     *
     * @return mixed
     *
     * @throws BindingResolutionException
     */
    public function handle(Request $request, \Closure $next)
    {
        if (true === $this->authService->check()) {
            $locale = $this->authService->user()->locale();
        } else {
            $desiredLocale = $request->segment(1);
            $locale = locale()->isSupported($desiredLocale) ? $desiredLocale : locale()->fallback();
        }

        locale()->set($locale);
        URL::defaults(['locale' => $locale]);

        return $next($request);
    }
}
