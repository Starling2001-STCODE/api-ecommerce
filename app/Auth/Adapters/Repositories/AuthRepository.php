<?php

namespace App\Auth\Adapters\Repositories;

use App\Auth\Domain\Contracts\AuthRepositoryPort;
use App\Auth\Domain\Entities\User;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Auth\Domain\Exceptions\InvalidCredentialsException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\User\Adapters\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\DB;

class AuthRepository implements AuthRepositoryPort
{
    public function login(User $user): array | null
    {
        if (Auth::attempt(['username' => $user->username, 'password' => $user->password])) {
            $authenticatedUser = Auth::user();
            $token = $authenticatedUser->createToken('token', ['*'], now()->addHours(15))->plainTextToken;
            return [
                'data' => [
                    'token' => $token,
                    'id' => $authenticatedUser->id,
                    'username' => $authenticatedUser->username,
                    'email' => $authenticatedUser->email,
                    'name' => $authenticatedUser->name,
                    'role' => $authenticatedUser->role,
                ],
                'message' => 'Authenticated'
            ];
        }

        throw new InvalidCredentialsException();
    }
    public function loginByEmail(string $email): array | null
    {
        $authenticatedUser = UserModel::where('email', $email)->first();
        if (!$authenticatedUser) {
            return null;
        }
        Auth::login($authenticatedUser);
        $token = $authenticatedUser->createToken('token', ['*'], now()->addHours(15))->plainTextToken;
        return [
            'data' => [
                'token' => $token,
                'id' => $authenticatedUser->id,
                'username' => $authenticatedUser->username,
                'email' => $authenticatedUser->email,
                'name' => $authenticatedUser->name,
                'role' => $authenticatedUser->role,
            ],
            'message' => 'Authenticated por Google'
        ];
    }
    
    public function logout(): void
    {
        Auth::user()->tokens()->delete();
    }

    public function me(): array | null
    {
        $authenticatedUser = Auth::user();
        return [
            'data' => [
                'id' => $authenticatedUser->id,
                'username' => $authenticatedUser->username,
                'email' => $authenticatedUser->email,
                'name' => $authenticatedUser->name,
                'role' => $authenticatedUser->role,
            ],
            'message' => 'Authenticated'
        ];
    }
    public function createUserFromGoogle(array $googleUserData): UserModel
    {
        $temporaryPassword = Str::random(10);

        $user = UserModel::create([
            'name' => $googleUserData['name'],
            'email' => $googleUserData['email'],
            'username' => explode('@', $googleUserData['email'])[0], 
            'email_verified_at' => now(), 
            'role' => 'empleado', // Luego lo cambiarás a 'cliente'
            'password' => Hash::make($temporaryPassword),
            'google_id' => $googleUserData['google_id'] ?? null,
            'provider' => 'google',
            'avatar' => $googleUserData['picture'] ?? null, // <-- INCLUIMOS AVATAR
        ]);
        // 🚀 Opcional: luego podemos enviar un email aquí con la contraseña temporal
        // $this->sendTemporaryPasswordEmail($user, $temporaryPassword);
        return $user;
    }
    public function sendResetPasswordEmail(string $email): void
    {
        $user = UserModel::where('email', $email)->first();

        if (!$user) {
            throw new \Exception('El correo electrónico no está registrado.');
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => $token,
                'created_at' => now()
            ]
        );

        $resetUrl = config('app.frontend_url') . "/reset-password/$token";

        Mail::to($email)->send(new ResetPasswordMail($resetUrl));
    }
    public function resetPassword(string $token, string $newPassword): void
    {
        $record = DB::table('password_reset_tokens')->where('token', $token)->first();

        if (!$record) {
            throw new \Exception('Token inválido.');
        }

        if (now()->diffInMinutes($record->created_at) > 60) {
            throw new \Exception('El token ha expirado.');
        }

        $user = UserModel::where('email', $record->email)->first();

        if (!$user) {
            throw new \Exception('Usuario no encontrado.');
        }

        $user->password = Hash::make($newPassword);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $user->email)->delete();
    }

}
