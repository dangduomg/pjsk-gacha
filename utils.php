<?php

// utilities

namespace MyServer;

function parse_query(
    string $query_string, callable $decoder = urldecode(...)
): array {
    // parses queries the standard-ish way (each options as arrays)
    // we hope that the url parser already validated the query string
    // then we just have to split the delimiters
    $pairs = $query_string === '' ? [] : explode("&", $query_string);
    $res = [];
    foreach ($pairs as $pair) {
        $parts = explode("=", $pair, 2);
        $key = $decoder($parts[0]);
        $value = $decoder($parts[1] ?? '');
        if (!\array_key_exists($key, $res)) {
            $res[$key] = [];
        }
        $res[$key][] = $value;
    }
    return $res;
}