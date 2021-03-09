<?php

namespace App\System\Illuminate\Service\Providers;

use Illuminate\Support\ServiceProvider;

abstract class SupportServiceProvider extends ServiceProvider
{
    /**
     * @return string[]
     */
    protected function regularBindings(): array
    {
        return [];
    }

    /**
     * @return string[]
     */
    protected function testingBindings(): array
    {
        return [];
    }

    public function register(): void
    {
        $testingBindings = $this->app->environment('testing') ? $this->testingBindings() : [];
        $bindings = array_replace($this->regularBindings(), $testingBindings);
        foreach ($bindings as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
