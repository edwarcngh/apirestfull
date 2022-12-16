<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;

use illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function login(LoginRequest $request){

        if(Auth::attempt($request->only('email', 'password'))){
            return response()->json([
                'token' => $request->user()->createToken($request->email.NOW().rand(200,500))->plainTextToken,
                'message' => 'Success'
            ]);
        }

        return response()->json([
            'message' => 'Unauthenticated'
        ], 401);
    }

}

