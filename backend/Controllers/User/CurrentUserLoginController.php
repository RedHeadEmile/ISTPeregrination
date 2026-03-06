<?php

namespace ISTPeregrination\Controllers\User;

use ISTPeregrination\Controllers\AbstractController;
use ISTPeregrination\Services\User\UserService;

class CurrentUserLoginController extends AbstractController
{
    public function __construct(array $vars)
    {
        parent::__construct($vars);
    }

    public function post(): void
    {
        list($email, $password) = json_body(['email', 'password']);

        $currentUser = UserService::getInstance()->login($email, $password);
        if ($currentUser === null) {
            http_response_code(401);
            echo json_encode(['error' => 'Invalid email or password']);
            return;
        }

        $this->jsonResponse($currentUser->getAsViewModel());
    }
}