<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    // Register new user
    public function register(array $data): User
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return $user;
    }

    public function login(array $validated): ?User
{
    $user = User::where('email', $validated['email'])->first();

    if ($user && Hash::check($validated['password'], $user->password)) {
        return $user;
    }

    return null;
}

    public function logout(): void
    {
        Auth::user()->tokens()->delete();
    }
}
