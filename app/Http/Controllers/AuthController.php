<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\UpdateMeRequest;
use App\Http\Resources\Resource;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;


class AuthController extends Controller {
    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function register(RegisterRequest $request): Resource {
        return new Resource($this->userRepository->register($request->all()));
    }

    public function login(LoginRequest $request): Resource {
        return new Resource($this->userRepository->login($request));
    }

    public function logout(Request $request): Resource {
        return new Resource($this->userRepository->logout($request));
    }

    public function me(Request $request): Resource {
        return new Resource($request->user());
    }

    public function updateMe(UpdateMeRequest $request): Resource {
        return new Resource($this->userRepository->updateMe($request));
    }

    public function resetPassword(ResetPasswordRequest $request): Resource {
        return new Resource($this->userRepository->resetPassword($request));
    }

    public function newPassword(ResetPasswordRequest $request): Resource {
        return new Resource($this->userRepository->newPassword($request));
    }
}