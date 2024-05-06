<?php
require_once('Controllers/SantaController.php');
require_once('Controllers/UserController.php');
class Router
{
    public function route()
    {
        if ($_SERVER['REQUEST_URI'] == "/main"){
            require 'Resources/main.php';
        }
        if ($_SERVER['REQUEST_URI'] == "/add_user") {
            $controller = new \Controllers\UserController();
            $controller->index();
        }
        if ($_SERVER['REQUEST_URI'] == "/message"){
            $controller = new \Controllers\UserController();
            $controller->addUser();
        }
        if ($_SERVER['REQUEST_URI'] == "/by_santa"){
            $controller = new \Controllers\SantaController();
            $controller->index();
        }
        if ($_SERVER['REQUEST_URI'] == "/get_recipient"){
            $controller = new \Controllers\SantaController();
            $controller->getRecipient();
        }
    }
}