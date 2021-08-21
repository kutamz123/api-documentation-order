<?php

namespace App\Http\Controllers\API;

class FormatResponse extends Controller
{
    private static $response = [
        "meta" => [
            "code" => 0,
            "status" => null,
            "message" => null
        ],
        "data" => null
    ];

    public static function success($code, $status, $message, $data)
    {
        self::$response["meta"]["code"] = $code;
        self::$response["meta"]["status"] = $status;
        self::$response["meta"]["message"] = $message;
        self::$response["data"] = $data;

        return response()->json(self::$response["data"], self::$response["meta"]["code"]);
    }

    public static function error($code, $status, $message)
    {
        self::$response["meta"]["code"] = $code;
        self::$response["meta"]["status"] = $status;
        self::$response["meta"]["message"] = $message;

        return response()->json(self::$response["data"], self::$response["meta"]["code"]);
    }
}
