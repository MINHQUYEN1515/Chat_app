<?php

namespace App\Helper;

class Helper
{
    public static function Success($status = 200)
    {
        return response()->json([
            'status' => 'success',
            'data' => null
        ], $status);
    }
    public static function SuccessWithMessage($message = '')
    {
        return response()->json([

            'status' => 200,
            'data' => $message
        ]);
    }
    public static function SuccessWithData($data = [], $status = 200, $message = '')
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
    }
    public static function Error($data = [], $status = 400, $message = '')
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
    }
}
