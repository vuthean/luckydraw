<?php

namespace App\Utils;

class ApiResponse
{
    public static function success($data = null, $message = "")
    {
        return response()->json([
            'code' => '000',
            'message' => $message,
            'data' => $data,
        ]);
    }
    public static function notfound($data = null, $message = "",$statusCode=404)
    {
        return response()->json([
            'code' => '404',
            'message' => $message,
            'data' => $data,
        ],$statusCode);
    }
    public static function error($message = null, $statusCode = 400)
    {
        return response()->json([
            'code' => (string) $statusCode,
            'message' => $message,
            'data' => null
        ], $statusCode);
    }

    public static function convertValidationErrors($response)
    {
        $response = json_decode($response, true);
        // Iterate over the data object to display the error messages
        $error = [];
        foreach ($response as $key => $value) {
            $error[$key]= $value[0];
        }
        return $error;
    }
}
