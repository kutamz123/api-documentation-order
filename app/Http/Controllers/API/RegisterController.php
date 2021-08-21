<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $input = $request->all();

        $rules = [
            "name" => "required|string",
            "username" => "alpha_num|required|min:3|max:25|unique:users,username",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:6"
        ];

        $messages = [
            "email.unique" => "email sudah dipakai"
        ];

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            return FormatResponse::error($validator->errors(), "Validasi gagal", 400);
        }

        return FormatResponse::success($order, "Berhasil memasukkan data", 201);
    }
}
