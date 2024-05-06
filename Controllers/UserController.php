<?php

namespace Controllers;

use Repository\UserRepository;
use Services\TemplateService;

require_once ('../Services/TemplateService.php');
require_once ('../Repository/UserRepository.php');

class UserController
{
    public function index()
    {
        require '../Resources/add_user.php';
    }

    public function getAll()
    {

    }
    public function addUser()
    {
        $templateInstance = TemplateService::getInstance();

        $name = $_REQUEST['name'] ?: null;
        $email = $_REQUEST['email'] ?: null;

        if (isset($name) && isset($email)) {
            UserRepository::addOne($name, $email);
            $data['message'] = "Пользователь $name, $email добавлен";
        } else {
            $data['message'] = "Недостаточно данных для добавления пользователя";
        }

        echo $templateInstance->render('message', $data);
    }
}