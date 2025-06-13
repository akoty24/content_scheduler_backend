<?php

namespace Modules\Auth\Services;

use Modules\Auth\Entities\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Modules\Tenants\Entities\Tenant;

class AuthService
{
    public function register(array $data): User
    {
        $tenant = Tenant::create(['name' => $data['tenant_name']]);

        $user = User::create([
            'name' => $data['name'],
            'tenant_id' => $tenant->id,
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
