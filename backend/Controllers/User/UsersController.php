<?php

namespace ISTPeregrination\Controllers\User;

use ISTPeregrination\Controllers\AbstractController;
use ISTPeregrination\Services\User\Models\UserModel;
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

    public function post(): void
    {
        $this->requireAuth();
        list($email, $password, $firstname, $lastname) = json_body(["email", "password", "firstname", "lastname"]);

        $email = verify_text($email, 0, 255);
        $firstname = htmlspecialchars(verify_text($firstname, 0, 255));
        $lastname = htmlspecialchars(verify_text($lastname, 0, 255));

        $newUser = new UserModel(
            0,
            $firstname,
            $lastname,
            $email,
            "",
            null,
            null,
        );

        try {
            $createdUser = UserService::getInstance()->register($newUser, $password);
            http_response_code(201);
            echo json_encode($createdUser->getAsViewModel());
        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
}
