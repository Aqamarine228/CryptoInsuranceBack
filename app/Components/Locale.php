<?php

namespace App\Components;

class Locale
{

    protected static string|array $configuredSupportedLocales = [];

    protected $app = '';

    public function __construct($app)
    {

        $this->app = $app;
    }

    public function current(): string
    {

        return $this->app->getLocale();
    }

    public function fallback()
    {

        return $this->app->make('config')['app.fallback_locale'];
    }

    public function set($locale): void
    {

        $this->app->setLocale($locale);
    }

    public function dir()
    {

        return $this->getConfiguredSupportedLocales()[$this->current()]['dir'];
    }

    public function nameFor($locale)
    {

        return $this->getConfiguredSupportedLocales()[$locale]['name'];
    }

    public function supported(): array
    {

        return array_keys($this->getConfiguredSupportedLocales());
    }

    public function isSupported($locale): bool
    {

        return in_array($locale, $this->supported());
    }

    protected function getConfiguredSupportedLocales(): array|string
    {

        // cache the array for future calls

        if (empty(static::$configuredSupportedLocales)) {
            static::$configuredSupportedLocales = $this->app->make('config')['app.supported_locales'];
        }

        return static::$configuredSupportedLocales;
    }
}
