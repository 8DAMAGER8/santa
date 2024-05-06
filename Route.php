<?php

require_once ('Router.php');
class Route
{
    public $route;
    public function __construct()
    {
        $this->route = new Router;
    }

    public function info()
    {
        $this->route->route();
    }
}