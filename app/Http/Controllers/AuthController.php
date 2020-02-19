<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\User;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    use ApiResponse;

    public function register(RegisterRequest $request)
    {
        $user = User::create(request()->all());

        return $this->apiResponse(['message' => 'user created successfully', 'result' => $user], 201);
    }

    public function login(AuthRequest $request)
    {
        $token = Str::random(80);

        $user = User::where([['email', $request->email], ['password', $request->password]])->first();
        if ($user) {
            $user->api_token = $token;
            $user->save();
            return $this->apiResponse(['message' => 'user login successfully', 'result' => $user], 200);
        }
        return $this->errorResponse(['message' => 'wrong email or password', 'result' => $user], 200);
    }

    public function logout()
    {
        User::where('api_token', \request()->user('api')->api_token)->update(['api_token' => null]);

        return $this->apiResponse(['message' => 'logged out successfully', 'result' => null], 200);
    }
}
