<?php

use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * @throws BindingResolutionException
 */
function locale()
{
    return app()->make(App\Components\Locale::class);
}
