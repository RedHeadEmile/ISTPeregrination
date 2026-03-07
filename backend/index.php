<?php

namespace ISTPeregrination;

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use ISTPeregrination\Controllers\ErrorHandlerController;
use ISTPeregrination\Controllers\MigrationController;
use ISTPeregrination\Controllers\MobilityReviews\MobilityReviewsApproveController;
use ISTPeregrination\Controllers\MobilityReviews\MobilityReviewsController;
use ISTPeregrination\Controllers\MobilityReviews\MobilityReviewsIndexController;
use ISTPeregrination\Controllers\User\CurrentUserController;
use ISTPeregrination\Controllers\User\CurrentUserLoginController;
use ISTPeregrination\Controllers\User\UserRegisterController;
use ISTPeregrination\Controllers\User\UserResetPasswordController;
use ISTPeregrination\Controllers\User\UserResetPasswordTokenController;
use ISTPeregrination\Controllers\User\UsersController;
use ISTPeregrination\Controllers\User\UserSendResetPasswordController;
use ISTPeregrination\Exceptions\NotFoundException;
use function FastRoute\simpleDispatcher;

require_once __DIR__ . '/vendor/autoload.php';

session_start();
define('__PROJECT_ROOT__', __DIR__);
define('__BASE_URL__', '');

header('Access-Control-Allow-Origin: ' . $_ENV['allowed_origin']);
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Credentials: true');

set_exception_handler(function (\Throwable $ex): void
{
    if ($_ENV['production'] === 'true') {
        http_response_code(500);
        die();
    }
    else
        internal_error($ex->__toString());
});

$dispatcher = simpleDispatcher(function (RouteCollector $r) {
    $r->addRoute(['GET', 'DELETE'], "/current-user", CurrentUserController::class);
    $r->addRoute(['POST'], "/send-reset-password", UserSendResetPasswordController::class);
    $r->addRoute(['POST'], "/reset-password", UserResetPasswordController::class);
    $r->addRoute(['GET'], "/reset-password-token/{token}", UserResetPasswordTokenController::class);
    $r->addRoute(['GET', 'POST'], "/users", UsersController::class);
    $r->addRoute(['POST'], "/login", CurrentUserLoginController::class);

    $r->addRoute(['GET', 'POST'], '/mobility-reviews', MobilityReviewsIndexController::class);
    $r->addRoute(['DELETE'], '/mobility-reviews/{id:\d+}', MobilityReviewsController::class);
    $r->addRoute(['POST'], '/mobility-reviews/{id:\d+}/approve', MobilityReviewsApproveController::class);

    $r->addRoute(['GET'], '/migration', MigrationController::class);
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case Dispatcher::NOT_FOUND:
        new ErrorHandlerController(['code' => 404, 'controller' => ErrorHandlerController::class])->get();
        break;
    case Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        new ErrorHandlerController(['code' => 405, 'allowedMethods' => $allowedMethods, 'controller' => ErrorHandlerController::class])->get();
        break;
    case Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $vars['controller'] = $handler;

        $controller = new $handler($vars);
        try {
            if (call_user_func(array($controller, strtolower($httpMethod))) === false) {
                new ErrorHandlerController(['code' => 500])->get();
            }
        }
        catch (NotFoundException) {
            new ErrorHandlerController(['code' => 404])->get();
        }

        break;
}
