<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\RoleResource;
use App\Models\Role;

class RoleController extends Controller {
    public function index(Request $request) {
        $limit = $request->has('limit') ? $request->get('limit') : null;
        return new RoleCollection(Role::paginate($limit));
    }

    public function store(RoleRequest $request) {
        return new RoleResource(Role::create($request->all()));
    }

    public function show(int $roleId) {
        return new RoleResource(Role::find($roleId));
    }

    public function update(RoleRequest $request, int $roleId) {
        $role = Role::find($roleId);
        $role->update($request->all());
        return new RoleResource($role);
    }

}