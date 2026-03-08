<?php

namespace ISTPeregrination\Controllers\User;

use ISTPeregrination\Controllers\AbstractController;
use ISTPeregrination\Exceptions\InvalidPasswordResetTokenException;
use ISTPeregrination\Exceptions\PasswordTooWeakException;
use ISTPeregrination\Services\User\UserService;

class UserResetPasswordController extends AbstractController
{
    public function __construct(array $vars)
    {
        parent::__construct($vars);
    }

    public function post(): void
    {
        list($token, $password) = json_body(['token', 'password']);
        try {
            UserService::getInstance()->resetPassword($token, $password);
            http_response_code(204);
        }
        catch (PasswordTooWeakException) {
            http_response_code(400);
            echo json_encode(["error" => "password_too_weak"]);
        } catch (InvalidPasswordResetTokenException) {
            http_response_code(400);
            echo json_encode(["error" => "invalid_token"]);
        }
    }
}
