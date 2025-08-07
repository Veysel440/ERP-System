<?php

namespace App\Exceptions;

use PHPUnit\Event\Code\Throwable;

class Handler
{
    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
                'errors'  => method_exists($exception, 'errors') ? $exception->errors() : null,
            ], method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500);
        }

        return parent::render($request, $exception);
    }

}
