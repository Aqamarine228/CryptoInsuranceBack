<?php

namespace Modules\Admin\Components;

use Illuminate\Support\Facades\Session;

class SessionAlerts
{
    const ERROR = 'error';
    const SUCCESS = 'success';
    const WARNING = 'warning';

    public function displayError()
    {
        return $this->display($this->getError());
    }

    public function displayWarning()
    {
        return $this->display($this->getWarning());
    }

    public function displaySuccess()
    {
        return $this->display($this->getSuccess());
    }

    public function error($messages)
    {
        $this->set(self::ERROR, $messages);
    }

    public function success($messages)
    {
        $this->set(self::SUCCESS, $messages);
    }

    public function warning($messages)
    {
        $this->set(self::WARNING, $messages);
    }

    public function getError()
    {
        return $this->get(self::ERROR);
    }

    public function getSuccess()
    {
        return $this->get(self::SUCCESS);
    }

    public function getWarning()
    {
        return $this->get(self::WARNING);
    }

    public function hasError()
    {
        return $this->has(self::ERROR);
    }

    public function hasSuccess()
    {
        return $this->has(self::SUCCESS);
    }

    public function hasWarning()
    {
        return $this->has(self::WARNING);
    }

    private function has($type)
    {
        return Session::has($type);
    }

    private function set($type, $messages)
    {
        Session::push($type, $messages);
    }

    private function get($type)
    {
        $message = Session::get($type);
        Session::forget($type);

        return $message;
    }

    private function display($messages)
    {
        $response = '';
        foreach ($messages as $message) {
            $response .= '<p>' . $message . '</p>';
        }

        return $response;
    }
}
