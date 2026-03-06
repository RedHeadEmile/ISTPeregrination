<?php

namespace ISTPeregrination\Controllers\User;

use ISTPeregrination\Controllers\AbstractController;
use ISTPeregrination\Services\User\UserService;

class UsersController extends AbstractController
{
    public function __construct(array $vars)
    {
        parent::__construct($vars);
    }

    public function get(): void
    {
        $this->requireAuth();

        $users = UserService::getInstance()->getAllUsers();
        $response = [];
        foreach ($users as $user) {
            $response[] = $user->getAsViewModel();
        }

        $this->jsonResponse($response);
    }
}