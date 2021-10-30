<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    //
    public function login(Request $request) {
        $validate = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validate->fails()) {
            return $this->responseJson(401,$validate->errors(),[]);
        }
        $user = User::where('username', $request->username)
                ->where('status','A')
                ->first();
        if(!$user){
            return $this->responseJson(401,"username not found or inactive");
        }

        if (! Hash::check($request->password, $user->password, [])) {
            return $this->responseJson(401,"wrong password");
        }

        $token = $user->createToken(env("APP_KEY","api_token_erp-diva"))->plainTextToken;
        $data = [
            'user'      => $user,
            'access_token'     => $token,
            'token_type' => 'Bearer'
            ];
        return $this->responseJson(201,"login success",$data);
    }

    public function me(Request $request){
        return $this->responseJson(200,"success",$request->user());
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return $this->responseJson(200,"logout success");
    }

    public function logoutall(Request $request) {
        $user = $request->user();
        $user->tokens()->delete();
        return $this->responseJson(200,"logout all success");
    }
}
