<?php

namespace App\User\Domain\Services;

use App\User\Domain\Contracts\UserRepositoryPort;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UpdateUserProfileService
{
    private UserRepositoryPort $userRepository;

    public function __construct(UserRepositoryPort $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(array $data)
    {
        $user = Auth::guard('sanctum')->user();

        // if (isset($data['avatar']) && $data['avatar']) {
        //     $avatarPath = $data['avatar']->store('avatars', 'public');
        //     if ($user->avatar) {
        //         Storage::disk('public')->delete($user->avatar);
        //     }
        //     $data['avatar'] = $avatarPath;
        // } else {
        //     unset($data['avatar']);
        // }
        $updatedUser = $this->userRepository->update($user->id, $data);

        return $updatedUser;
    }
}
