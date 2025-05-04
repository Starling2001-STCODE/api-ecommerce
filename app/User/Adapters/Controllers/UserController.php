<?php

namespace App\User\Adapters\Controllers;

use App\Core\Controllers\BaseController;
use App\User\Domain\Services\CreateUserService;
use App\User\Domain\Services\FindUserByIdService;
use App\User\Domain\Services\ListUsersService;
use App\User\Domain\Services\UpdateUserProfileService;
use App\User\Http\Requests\UpdateUserProfileRequest;
use App\User\Http\Requests\CreateUserRequest;
use App\User\Domain\Services\GetAuthenticatedUserService;
use App\User\Http\Resources\UserProfileResource; 
use App\User\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class UserController extends BaseController
{
    private CreateUserService $createUserService;
    private ListUsersService $listUsersService;
    private FindUserByIdService $findUserByIdService;
    private UpdateUserProfileService $updateUserProfileService;
    private GetAuthenticatedUserService $getAuthenticatedUserService;

    public function __construct(
        CreateUserService $createUserService, 
        ListUsersService $listUsersService, 
        FindUserByIdService $findUserByIdService,
        UpdateUserProfileService $updateUserProfileService,
        GetAuthenticatedUserService $getAuthenticatedUserService)
    {
        $this->createUserService = $createUserService;
        $this->listUsersService = $listUsersService;
        $this->findUserByIdService = $findUserByIdService;
        $this->updateUserProfileService = $updateUserProfileService;
        $this->getAuthenticatedUserService = $getAuthenticatedUserService;
    }

    public function index(Request $request)
    {
        $perPage = $this->getPerPage($request);
        $users = $this->listUsersService->execute($perPage);
        return UserResource::collection($users);
    }

    public function store(CreateUserRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = $this->createUserService->execute($data);
        return (new UserResource($user))->response()
            ->setStatusCode(201);
    }

    public function show($id)
    {
        $user = $this->findUserByIdService->execute($id);
        return (new UserResource($user));
    }
    public function getProfile()
    {
        $user = $this->getAuthenticatedUserService->execute();

        return new UserProfileResource($user);
    }
    public function updateProfile(UpdateUserProfileRequest $request)
    {
        $validated = $request->validated();
        $user = $this->updateUserProfileService->execute($validated);

        return (new UserProfileResource($user));
    }
}
