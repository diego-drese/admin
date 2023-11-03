<?php

namespace App\Http\Controllers;

use App\Http\Requests\RolesRequest;
use App\Http\Resources\Resource;
use App\Http\Resources\Collection;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;

class RolesController extends Controller {
    private $roleRepository;

    public function __construct(RoleRepository $roleRepository) {
        $this->roleRepository = $roleRepository;
    }

    public function index(Request $request){
        return new Collection($this->roleRepository->paginate($request));
    }

    public function store(RolesRequest $request){
        return new Resource($this->roleRepository->add($request->all()));
    }

    public function show($id){
        return new Resource($this->roleRepository->find($id));
    }

    public function update(RolesRequest $request, $id){
        return new Resource($this->roleRepository->update($request->all(), $id));
    }

    public function destroy($id){
        return new Resource($this->roleRepository->destroy($id));
    }

}
