<?php

// router

namespace MyServer;

require './errors.php';
require './send.php';
require './utils.php';

class Arguments {
    // arguments extracted from url and method

    protected function __construct(
        public readonly string $method,
        public readonly array $path,
        public readonly array $query,
    ) {}

    public static function from_url(
        string $method, string $pat, string $url
    ): self | null {
        // extract arguments from url
        // base url is needed to prevent parse_url from misinterpreting paths
        $parsed_url = parse_url("http://url$url");
        if ($parsed_url === false)
            throw new BadRequestException();
        if ($parsed_url['path'] === null)
            throw new BadRequestException();
        $path_string = rawurldecode($parsed_url['path']);
        $match_res = preg_match($pat, $path_string, $path);
        if ($match_res === false)
            throw new \ValueError("$pat is not a valid pattern");
        if ($match_res === 0)
            return null;
        $query = parse_query($parsed_url['query'] ?? '');
        return new self($method, $path, $query);
    }
}

class Router {
    // the router

    /* callback schema:
     * function(Arguments $args): ['headers' => array, 'body' => string]
     */

    public array $routes = [];

    public function add_route(
        string $method, string $pat, callable $callback
    ) {
        $this->routes[$method][$pat] = $callback;
    }

    public function route(string $method, string $url) {
        // route the request
        $available_methods = $this->available_methods();
        if (!\in_array($method, $available_methods)) {
            send_error(405, [
                'Allow' => implode(', ', $available_methods),
            ]);
            return;
        }
        $method_routes = $this->routes[$method];
        foreach ($method_routes as $pat => $callback) {
            try {
                $args = Arguments::from_url($method, $pat, $url);
                if ($args !== null) {
                    $res = $callback($args);
                    send_success($res['body'], $res['headers']);
                    return;
                }
            } catch (RequestException $e) {
                send_error($e::status_code);
                return;
            } catch (\Throwable $e) {
                send_error(500);
                throw $e;
            }
        }
        send_error(404);
    }

    public function available_methods(): array {
        return array_keys($this->routes);
    }
}