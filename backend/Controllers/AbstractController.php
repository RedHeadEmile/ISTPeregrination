<?php

namespace ISTPeregrination\Controllers;

use ISTPeregrination\Services\User\Models\UserModel;

abstract class AbstractController
{
    protected readonly array $vars;

    /**
     * @param array $vars Variables passed in the url
     */
    public function __construct(array $vars)
    {
        $this->vars = $vars;
    }

    /**
     * Get the actual logged user
     * @return UserModel|null The actuel logged user
     */
    final protected function getCurrentUser(): ?UserModel
    {
        if (isset($_SESSION['user']))
            return $_SESSION['user'];
        return null;
    }

    /**
     * Require the user to be logged in, otherwise it will return a 401 error and stop the execution
     * @return void
     */
    final protected function requireAuth(): void
    {
        if ($this->getCurrentUser() === null) {
            http_response_code(401);
            die();
        }
    }

    /**
     * Get the content of the body as a string
     * @return string The content of the body
     */
    final protected function getStringBody(): string
    {
        return file_get_contents('php://input');
    }

    /**
     * Get the content of the body as json
     * @return mixed The content of the body
     */
    final protected function getJsonBody(): mixed
    {
        $payload = json_decode($this->getStringBody(), true);
        if ($payload === null) {
            http_response_code(400);
            die();
        }
        return $payload;
    }

    /**
     * Send a json response with the given data and http status code
     * @param mixed $data The data to send as json
     * @param int $statusCode The http status code to send (default: 200)
     * @return void
     */
    final protected function jsonResponse(mixed $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    /**
     * Handle POST request with this methode (should be registered in routes)
     * @return void
     */
    public function post(): void {}

    /**
     * Handle HEAD request with this methode (should be registered in routes)
     * @return void
     */
    public function head(): void {}

    /**
     * Handle GET request with this methode (should be registered in routes)
     * If not redefined, it will call the renderall function
     * @return void
     */
    public function get(): void {}

    /**
     * Handle PUT request with this methode (should be registered in routes)
     * @return void
     */
    public function put(): void {}

    /**
     * Handle PATCH request with this methode (should be registered in routes)
     * @return void
     */
    public function patch(): void {}

    /**
     * Handle DELETE request with this methode (should be registered in routes)
     * @return void
     */
    public function delete(): void {}

    /**
     * Trim and check a string
     * @param string $key The key corresponding the value in the array
     * @param array $arr The array of values
     * @param int $maxLength The maximum length of the string (otherwise it will return null)
     * @param int $minLength The minimum length of the string (otherwise it will return null)
     * @param bool $nullIfEmpty If TRUE, it will return null if the trimmed string is empty
     * @return string|null The trimmed string or null if the string does not respect the predicate
     */
    public function trim(string $key, array $arr, int $maxLength = -1, int $minLength = -1, bool $nullIfEmpty = false): ?string
    {
        $var = $arr[$key] ?? null;
        if ($var === null)
            return null;
        $var = trim($var);
        $len = strlen($var);
        return ($maxLength > -1 && $len > $maxLength) || ($nullIfEmpty && $len == 0) || ($minLength > -1 && $len < $minLength) ? null : $var;
    }
}