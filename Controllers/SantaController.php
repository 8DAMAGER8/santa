<?php

namespace Controllers;

use Repository\UserRepository;
use Services\TemplateService;

require_once ('../Services/TemplateService.php');
require_once ('../Repository/UserRepository.php');

class SantaController
{
    public function index()
    {
        require '../Resources/santa.php';
    }

    public function getRecipient()
    {
        $templateInstance = TemplateService::getInstance();

        $santaEmail = $_REQUEST['email'] ?: null;
        $allUsersWithoutSanta = UserRepository::getAllWithoutSanta($santaEmail);

        if ($allUsersWithoutSanta > 0) {
            $randomKey = array_rand($allUsersWithoutSanta);
            $randomUserWithoutSanta = $allUsersWithoutSanta[$randomKey];
            $data['message'] = "Вам назначен получатель: " . $randomUserWithoutSanta['name'] . ',' . $randomUserWithoutSanta['email'];
        } else {
            $data['message'] = "Не удалось найти цель для подарка";
        }

        echo $templateInstance->render('message', $data);
    }
}