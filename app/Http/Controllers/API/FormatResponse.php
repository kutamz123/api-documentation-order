<?php

namespace App\Http\Controllers\API;

class FormatResponse
{
    private static $response = [
        "meta" => [
            "code" => 0,
            "status" => null,
            "message" => null
        ],
        "data" => null
    ];

    public static function success($data, $message, $code)
    {
        self::$response["meta"]["code"] = $code;
        self::$response["meta"]["status"] = "success";
        self::$response["meta"]["message"] = $message;
        self::$response["data"] = $data;

        return response()->json(self::$response, self::$response["meta"]["code"]);
    }

    public static function error($data, $message, $code)
    {
        self::$response["meta"]["code"] = $code;
        self::$response["meta"]["status"] = "error";
        self::$response["meta"]["message"] = $message;
        self::$response["data"] = $data;

        return response()->json(self::$response, self::$response["meta"]["code"]);
    }
}
