<?php

// the main handler

require 'router.php';
require 'algorithm/test.php';

$my_router = new \MyServer\Router();

$my_router->add_route('GET', '#^/api/pull1$#', fn($args) => [
    'headers' => [
        'Content-Type' => 'application/json; charset=utf-8',
    ],
    'body' => json_encode([
        'status' => 'success',
        'message' => [\Gacha\PJSK\Test\gacha->pull1()]
    ])
]);

$my_router->add_route('GET', '#^/api/pull10$#', fn($args) => [
    'headers' => [
        'Content-Type' => 'application/json; charset=utf-8',
    ],
    'body' => json_encode([
        'status' => 'success',
        'message' => \Gacha\PJSK\Test\gacha->pull10()
    ], JSON_THROW_ON_ERROR)
]);

$my_router->route($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);