<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Http\Requests\RegisterRequest;
use Modules\Auth\Http\Resources\UsersResource;
use Modules\Auth\Services\AuthService;

class AuthController extends Controller
{    public function __construct(private AuthService $authService) {}
       public function register(RegisterRequest $request)
    {

        $data = $request->validated();
        
        $user = $this->authService->register($data);

        if (!$user) {
            return error('User already exists ', 422);
        }
         $token = $user->createToken('auth_token')->plainTextToken;

       $data=[
            'user' => UsersResource::make($user),
            'token' => $token,
            'token_type' => 'Bearer'
        ];
        return success(
            $data
        , 'User registered successfully');
    
    }

    public function login(LoginRequest $request)
    {
        $user = $this->authService->login($request->validated());

        if (!$user) {
            return error('Invalid credentials', 401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        $data=[
            'user' => UsersResource::make($user),
            'token' => $token,
            'token_type' => 'Bearer'
        ];
        return success(
            $data, 'Logged in successfully');
    }
      public function logout()
    {
        $this->authService->logout();
        return success(null,' Logged out successfully');
    }

    public function user(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return error('User not found', 404);
        }
        return success(UsersResource::make($user), 'User retrieved successfully');
    }
}
