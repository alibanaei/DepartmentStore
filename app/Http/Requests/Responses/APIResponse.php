<?php

namespace App\Http\Requests\Responses;

use Illuminate\Http\Response;

class APIResponse extends Response
{
    public static function makeFail($message, array $errors = [], $errorCode = 200)
    {
        return self::make(false, ['message' => $message, 'errors' => $errors], $errorCode);
    }

    public static function makeSuccess($message, $data = [])
    {
        if (is_array($data)) {
            $data['message'] = $message;
        } elseif (is_object($data)) {
            $data->message = $message;
        } else {
            $data = ['message' => 'خطایی رخ داده است.'];
        }

        return self::make(true, $data);
    }

    private static function make($success, $respondObj = [], $respondCode = 200)
    {
        if (! $success && $respondCode == 200 && empty($respondObj)) {
            $respondCode = 500;
        }

        $respond = [
            'result' => $success,
            'data' => $respondObj,
            'time' => date('Y-m-d H:i:s'),
        ];

        return response()->json($respond, $respondCode);
    }
}
