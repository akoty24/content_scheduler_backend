<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UsersResource;
use App\Services\AuthService;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    

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
        $user->load(['posts', 'platforms']);
        $token = $user->createToken('auth_token')->plainTextToken;
        $data=[
            'user' => UsersResource::make($user),
            'token' => $token,
            'token_type' => 'Bearer'
        ];
        return success(
            $data, 'Logged in successfully');
    }

    public function profile(){
        $user = auth()->user();
        if (!$user) {
            return error('Unauthorized', 401);
        }
        $user->load(['posts', 'platforms']);

        return success([
            'user' => UsersResource::make($user),
        ], 'User profile retrieved successfully');
    }
    public function logout()
    {
        $this->authService->logout();
        return success(null,' Logged out successfully');
    }
}
