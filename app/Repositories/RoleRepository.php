<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class RoleRepository implements RepositoryInterface {
    private $model;

    public function __construct(Role $model) {
        $this->model = $model;
    }

    public function find($id) {
        return $this->model->with('resources')->find($id);
    }

    public function paginate(Request $request) {
        return $this->model->with('resources')->paginate($request->get('limit', 10));
    }

    public function add(array $data) {
        $role = $this->model->create(['name' => $data['name'], 'status' => 1]);
        $role->resources()->sync($data['resources']);
        return $this->find($role->id);
    }

    public function update(array $data, $id) {
        $role = $this->find($id);
        $role->name = $data['name'];
        $role->status = $data['status'];
        $role->resources()->sync($data['resources']);
        $role->save();
        return $this->find($id);
    }

    public function destroy($id) {
        $role = $this->find($id);
        if ($role) {
            try {
                $role->delete();
                return ['message' => 'Role deleted successfully'];
            } catch (QueryException $e) {
                return ['message' => $e->getMessage()];
            }

        }
        return ['message' => 'Role not found'];
    }

    public function hasName($name) {
        return $this->model->where('name', $name)->first();
    }
}