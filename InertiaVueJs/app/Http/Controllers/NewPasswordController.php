<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class NewPasswordController extends Controller
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function edit(int $id, string $token)
    {
        $user = $this->userRepository->findOrFail($id);

        if (! $user->hasNewPasswordTokenValid($token)) {
            return to_route('login')->with('status', 'Jeton de sécurité invalide.');
        }

        return Inertia::render('User/NewPassword', [
            'user' => $user,
            'token' => $token,
            'use_pin' => $user->hasAnyRole(Role::MOBILE_ROLES),
        ]);
    }

    public function update(Request $request, int $id, string $token)
    {
        $user = $this->userRepository->findOrFail($id);

        if (! $user->hasNewPasswordTokenValid($token)) {
            return to_route('login')->with('status', 'Jeton de sécurité invalide.');
        }

        $rules = ['required'];

        if (! $request->boolean('pin')) {
            $rules[] = Password::defaults();
            $rules[] = 'confirmed';
        }

        $validated = $request->validate(['password' => $rules]);

        $user->forceFill([
            'password' => bcrypt($validated['password']),
            'new_password_token' => null,
            'new_password_token_expiration_date' => null,
        ])->save();

        if ($request->boolean('pin')) {
            return to_route('login')->with('success', 'Votre mot de passe a bien été modifié.');
        } else {
            Auth::login($user);

            $request->session()->regenerate();

            return to_route('dashboard')->with('success', 'Votre mot de passe a bien été modifié.');
        }
    }
}
