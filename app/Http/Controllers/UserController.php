<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\Resource;
use App\Http\Resources\Collection;
use App\Repositories\userRepository;
use Illuminate\Http\Request;

class UserController extends Controller {
    private $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request){
        return new Collection($this->userRepository->paginate($request));
    }

    public function store(UserRequest $request){
        return new Resource($this->userRepository->add($request->all()));
    }

    public function show($id){
        return new Resource($this->userRepository->find($id));
    }

    public function update(UserRequest $request, $id){
        return new Resource($this->userRepository->update($request->all(), $id));
    }

    public function destroy($id){
        return new Resource($this->userRepository->destroy($id));
    }

}
