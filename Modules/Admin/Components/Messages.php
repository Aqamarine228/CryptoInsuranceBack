<?php

namespace Modules\Admin\Components;

use Illuminate\Support\Facades\Session;

class Messages
{
    public const ERROR = 'error';
    public const SUCCESS = 'success';
    public const WARNING = 'warning';

    public static function displayError(): string
    {
        return self::display(self::getError());
    }

    public static function displayWarning(): string
    {
        return self::display(self::getWarning());
    }

    public static function displaySuccess(): string
    {
        return self::display(self::getSuccess());
    }

    public static function error($messages): void
    {
        self::set(self::ERROR, $messages);
    }

    public static function success($messages): void
    {
        self::set(self::SUCCESS, $messages);
    }

    public static function warning($messages): void
    {
        self::set(self::WARNING, $messages);
    }

    public static function getError()
    {
        return self::get(self::ERROR);
    }

    public static function getSuccess()
    {
        return self::get(self::SUCCESS);
    }

    public static function getWarning()
    {
        return self::get(self::WARNING);
    }

    public static function hasError(): bool
    {
        return self::has(self::ERROR);
    }

    public static function hasSuccess(): bool
    {
        return self::has(self::SUCCESS);
    }

    public static function hasWarning(): bool
    {
        return self::has(self::WARNING);
    }

    protected static function has($type): bool
    {
        return Session::has($type);
    }

    protected static function set($type, $messages): void
    {
        Session::push($type, $messages);
    }

    protected static function get($type)
    {
        $message = Session::get($type);
        Session::forget($type);

        return $message;
    }

    protected static function display($messages): string
    {
        $response = '';
        foreach ($messages as $message) {
            $response .= '<p>' . $message . '</p>';
        }

        return $response;
    }
}
