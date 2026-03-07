<?php

namespace ISTPeregrination\Controllers\User;

use ISTPeregrination\Controllers\AbstractController;
use ISTPeregrination\Services\User\UserService;

class UserSendResetPasswordController extends AbstractController
{
    public function __construct(array $vars)
    {
        parent::__construct($vars);
    }

    public function post(): void
    {
        list($email) = json_body(['email']);
        UserService::getInstance()->sendResetPassword($email);
        http_response_code(204);
    }
}