<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\FormatResponse;

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
            "username.unique" => "username sudah digunakan",
            "email.unique" => "email sudah digunakan"
        ];

        $validator = Validator::make($input, $rules, $messages);

        if ($validator->fails()) {
            return FormatResponse::error($validator->errors(), "Validasi gagal", 422);
        }

        $register = User::create([
            "name" => $request->input("name"),
            "username" => $request->input("username"),
            "email" => $request->input("email"),
            "password" => bcrypt($request->input("password"))
        ]);

        $token = $register->createToken($request->input("email"));

        return FormatResponse::success(["user" => $register, "token" => $token->plainTextToken], "Berhasil memasukkan data", 201);
    }
}
