<?php

// errors

namespace MyServer;

abstract class RequestException extends \Exception {}

class ForbiddenException extends RequestException {
    public const status_code = 403;
}

class NotFoundException extends RequestException {
    public const status_code = 404;
}

class BadRequestException extends RequestException {
    public const status_code = 400;
}