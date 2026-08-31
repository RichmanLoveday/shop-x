<?php

namespace App\Exceptions;

use Exception;

class CartEmptyException extends Exception
{
    public function __construct(string $message = 'Your cart is empty', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
