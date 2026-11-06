<?php

// the main handler

namespace MyServer;

require 'router.php';
require 'algorithm/test.php';

use const Gacha\PJSK\Test\gacha;

$my_router = new Router();

$my_router->add_route('GET', '#^/(?:index.php)?$#', function($args) {
    http_response_code(301);
    send_headers(['Location' => '/client']);
    throw new OverrideDefaultException();
});

$my_router->add_route('GET', '#^/api/pull1$#', fn($args) => [
    'headers' => [
        'Content-Type' => 'application/json; charset=utf-8',
    ],
    'body' => json_encode([
        'status' => 'success',
        'message' => [gacha->pull1()]
    ])
]);

$my_router->add_route('GET', '#^/api/pull10$#', fn($args) => [
    'headers' => [
        'Content-Type' => 'application/json; charset=utf-8',
    ],
    'body' => json_encode([
        'status' => 'success',
        'message' => gacha->pull10()
    ], JSON_THROW_ON_ERROR)
]);

$my_router->route($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);