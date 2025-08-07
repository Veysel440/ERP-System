<?php

namespace App\Http\Responses;

class ApiResponse
{
    public static function success($data = null, $message = 'İşlem başarılı', $code = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    public static function error($message = 'Bir hata oluştu', $errors = null, $code = 500)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors'  => $errors,
        ], $code);
    }
}
