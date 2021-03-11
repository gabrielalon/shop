<?php

namespace App\System\Illuminate;

use Illuminate\Foundation\Application;

final class Locale
{
    /** @var Application */
    private Application $app;

    /**
     * Locale constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @return string
     */
    public function current(): string
    {
        return $this->app->getLocale();
    }

    /**
     * @return string
     */
    public function fallback(): string
    {
        return $this->app->make('config')['app.fallback_locale'];
    }

    /**
     * @param string $locale
     */
    public function set(string $locale): void
    {
        $this->app->setLocale($locale);
    }

    /**
     * @return string
     */
    public function dir(): string
    {
        return $this->getConfiguredSupportedLocales()[$this->current()]['dir'];
    }

    /**
     * @param string $locale
     *
     * @return string
     */
    public function nameFor(string $locale): string
    {
        return $this->getConfiguredSupportedLocales()[$locale]['name'];
    }

    /**
     * @return string[]
     */
    public function supported(): array
    {
        return array_keys($this->getConfiguredSupportedLocales());
    }

    /**
     * @param string|null $locale
     *
     * @return bool
     */
    public function isSupported(?string $locale = null): bool
    {
        return in_array($locale, $this->supported(), true);
    }

    /**
     * @return string[][]
     */
    private function getConfiguredSupportedLocales(): array
    {
        return $this->app->make('config')['app.supported_locales'];
    }
}
