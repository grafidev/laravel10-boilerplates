<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Hash;

class AuthenticatorApiService
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function handle(array $credentials)
    {
        $user = $this->userRepository
            ->query()
            ->where('email', $credentials['email'])
            ->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return null;
        }

        $token = auth('api')->login($user);
        event(new Login('api', $user, false));

        return $token;
    }
}
