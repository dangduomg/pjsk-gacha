<?php

// helpers for sending responses in php

namespace MyServer;

require './status-messages.php';

function send_headers($header_array) {
    // use an array of headers instead of strings
    // better that way
    foreach ($header_array as $key => $value) {
        header("$key: $value");
    }
}

function send_success($body, $additional_headers = []) {
    http_response_code(200);
    send_headers($additional_headers);
    echo $body;
}

function send_error($code, $additional_headers = []) {
    $message = HTTP_STATUS_CODES[$code] ?? 'Unknown Status';
    http_response_code($code);
    send_headers($additional_headers);
    send_headers(['Content-Type' => 'text/html']);
}