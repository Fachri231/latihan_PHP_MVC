<?php
class Controller
{
    public function views($view, $data = [])
    {
        require_once '../app/views/' . $view . '.php';
    }

    public function models($model)
    {
        require_once '../app/models/' . $model . '.php';
        return new $model;
    }
}