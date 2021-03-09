<?php

namespace App\UI\Web\Index;

use App\UI\Web\WebHandler;
use Illuminate\Contracts\Support\Renderable;

class IndexHandler extends WebHandler
{
    /**
     * @return Renderable
     */
    public function __invoke(): Renderable
    {
        return view('web.index');
    }
}
