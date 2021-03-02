<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\UserDeletedResource;

use App\Http\Requests\User\UpdateUser;
use App\Http\Requests\User\ChangePassword;

use App\Services\UserService;

class UsersController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;


    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->authorizeResource(User::class);
    }

    /**
     * Gets list of users
     *
     * @return UserResource collection
     */
    public function index()
    {
        $users = $this->userService->getListUsers();

        return UserResource::collection($users);
    }


    /**
     * Delete a user
     *
     * @param  User $user
     * @return UserDeletedResource
     */
    public function delete(User $user) : UserDeletedResource
    {
        $resource = new UserDeletedResource($user);

        $result = $this->userService->delete($user);

        return $resource;
    }
}
