<?php

namespace App\UI\Web;

use Illuminate\Contracts\Support\Renderable;

class WelcomeHandler extends WebHandler
{
    /**
     * @param string $locale
     *
     * @return Renderable
     */
    public function __invoke(string $locale): Renderable
    {
        return view('welcome');
    }
}
