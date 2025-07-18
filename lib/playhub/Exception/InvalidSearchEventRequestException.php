<?php

namespace Playhub\Exception;

class InvalidSearchEventRequestException extends \Exception
{
    public function __construct(private readonly array $errors)
    {
        parent::__construct();
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
