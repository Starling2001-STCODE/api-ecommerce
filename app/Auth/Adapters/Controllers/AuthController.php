<?php

namespace App\Auth\Adapters\Controllers;

use App\Auth\Domain\Services\LoginService;
use App\Auth\Domain\Services\LogoutService;
use App\Auth\Domain\Services\MeService;
use App\Auth\Domain\Services\LoginWithGoogleService;
use App\Auth\Domain\Contracts\AuthRepositoryPort;
use App\Auth\Http\Requests\ForgotPasswordRequest;
use App\Auth\Http\Requests\ResetPasswordRequest;
use App\Auth\Http\Requests\LoginRequest;
use App\Auth\Http\Requests\GoogleLoginRequest;
use Symfony\Component\Uid\Ulid;
use Illuminate\Http\JsonResponse;

class AuthController
{
    private LoginService $loginService;
    private LogoutService $logoutService;
    private MeService $meService;
    private LoginWithGoogleService $loginWithGoogleService;
    private AuthRepositoryPort $authRepository;

    public function __construct(
        LoginService $loginService, 
        LogoutService $logoutService, 
        MeService $meService,
        LoginWithGoogleService $loginWithGoogleService,
        AuthRepositoryPort $authRepository,)
    {
        $this->loginService = $loginService;
        $this->logoutService = $logoutService;
        $this->meService = $meService;
        $this->loginWithGoogleService = $loginWithGoogleService;
        $this->authRepository = $authRepository;
    }


    public function login(LoginRequest $request)
    {
        session(['session_ulid' => (string) new Ulid()]);

        $user = $this->loginService->execute($request->username, $request->password);
        return response()->json($user, 200);
    }

    public function logout()
    {
        $this->logoutService->execute();
        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    public function me()
    {
        $user = $this->meService->execute();
        return response()->json($user, 200);
    }
    public function loginWithGoogle(GoogleLoginRequest $request)
    {
        $idToken = $request->validated()['id_token'];
        $loginResult = $this->loginWithGoogleService->execute($idToken);
        return response()->json($loginResult, 200);
    }
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $this->authRepository->sendResetPasswordEmail($request->input('email'));

        return response()->json(['message' => 'Se envió un enlace de restablecimiento a tu correo.']);
    }
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $this->authRepository->resetPassword($request->input('token'), $request->input('password'));

        return response()->json(['message' => 'Tu contraseña ha sido actualizada correctamente.']);
    }
}
