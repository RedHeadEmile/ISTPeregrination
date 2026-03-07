<?php

namespace ISTPeregrination\Controllers\User;

use ISTPeregrination\Controllers\AbstractController;
use ISTPeregrination\Services\User\UserService;

class UserResetPasswordTokenController extends AbstractController
{
    public function __construct(array $vars)
    {
        parent::__construct($vars);
    }

    public function get(): void
    {
        $token = $this->vars['token'] ?? null;
        if ($token === null || !preg_match('/^[a-zA-Z0-9]{200}$/', $token)) {
            http_response_code(400);
            die();
        }

        $isValid = UserService::getInstance()->isResetPasswordTokenValid($token);
        $this->jsonResponse(['valid' => $isValid]);
    }
}