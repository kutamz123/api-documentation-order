<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\FormatResponse;

class LoginController extends Controller
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
            "email" => "required",
            "password" => "required"
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return FormatResponse::error($validator->errors(), "Validasi gagal", 422);
        }

        $user = User::where("email", $request->input("email"))->first();

        if (!$user || !Hash::check($request->input("password"), $user->password)) {
            return FormatResponse::error(null, "Username / Password salah", 401);
        }

        $token = $user->createToken($request->input("email"));

        return FormatResponse::success(["token" => $token->plainTextToken], "Berhasil login", 200);
    }
}
