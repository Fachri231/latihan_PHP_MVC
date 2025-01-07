<?php
namespace App\Core;

class Controller
{
    public function views($view, $data = [])
    {
        require_once  '../app/views/' . $view . '.php';
    }

    public function models($model)
    {
        $modelClass = '\\App\\Models\\' . $model;
        return new $modelClass;
    }
}