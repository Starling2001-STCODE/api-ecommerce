<?php

namespace App\User\Domain\Services;

use App\User\Domain\Contracts\UserRepositoryPort;
use App\User\Domain\Services\SendEmailVerificationService;
use App\User\Domain\Entities\User as DomainUser;
use App\Models\User as EloquentUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateUserService
{
    private UserRepositoryPort $userRepository;
    private SendEmailVerificationService $sendEmailVerificationService;

    public function __construct(UserRepositoryPort $userRepository, SendEmailVerificationService $sendEmailVerificationService 
    ) 
    {
        $this->userRepository = $userRepository;
        $this->sendEmailVerificationService = $sendEmailVerificationService;
    }

    public function execute(array $data): DomainUser
    {
        return DB::transaction(function () use ($data) {
            $password = Hash::make($data['password']);
            $data['password'] = $password;
            $user = new DomainUser($data);
            $createdUser = $this->userRepository->create($user);
            $eloquentUser = EloquentUser::where('id', $createdUser->id)->firstOrFail();
            $this->sendEmailVerificationService->executeFor($eloquentUser);
            return $createdUser;
        });
    }
}
