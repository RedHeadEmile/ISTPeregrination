<?php

namespace ISTPeregrination\Controllers\User;

use ISTPeregrination\Controllers\AbstractController;
use ISTPeregrination\Services\User\UserService;

class CurrentUserController extends AbstractController
{
    public function __construct(array $vars)
    {
        parent::__construct($vars);
    }

    public function get(): void
    {
        $this->requireAuth();
        $this->jsonResponse($this->getCurrentUser()->getAsViewModel());
    }

    public function delete(): void
    {
        $this->requireAuth();
        UserService::getInstance()->logout();
    }
}