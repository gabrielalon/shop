<?php

namespace App\UI\Web\Admin\User;

use App\UI\Web\WebHandler;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class UserLoginHandler extends WebHandler
{
    /** @var Factory */
    private Factory $factory;

    /**
     * LoginHandler constructor.
     * @param Factory $factory
     */
    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @return View
     */
    public function __invoke(): View
    {
        return $this->factory->make('admin.account.login');
    }
}
