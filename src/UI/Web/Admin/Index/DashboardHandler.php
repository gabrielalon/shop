<?php

namespace App\UI\Web\Account\Admin;

use App\UI\Web\WebHandler;
use Illuminate\Contracts\Support\Renderable;

class DashboardHandler extends WebHandler
{
    /**
     * @return Renderable
     */
    public function __invoke(): Renderable
    {
        return view('admin.account.dashboard');
    }
}
