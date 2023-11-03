<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class UserRepository implements RepositoryInterface {
    private $model;

    public function __construct(User $model) {
        $this->model = $model;
    }

    public function find($id) {
        return $this->model->with('roles')->find($id);
    }

    public function paginate(Request $request) {
        return $this->model->paginate($request->get('limit', 10));
    }

    public function add(array $data) {
        $user = $this->model->create(['name' => $data['name'], 'email' => $data['email'], 'password'=>bcrypt($data['password'])]);
        $user->roles()->sync($data['roles']);
        return $this->find($user->id);
    }

    public function update(array $data, $id) {
        $user = $this->find($id);
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->roles()->sync($data['roles']);
        $user->save();
        return $this->find($id);
    }

    public function destroy($id) {
        $user = $this->find($id);
        if ($user) {
            try {
                $user->delete();
                return ['message' => 'User deleted successfully'];
            } catch (QueryException $e) {
                return ['message' => $e->getMessage()];
            }

        }
        return ['message' => 'User not found'];
    }

    public function hasName($name) {
        return $this->model->where('name', $name)->first();
    }
    public function hasEmail($email) {
        return $this->model->where('email', $email)->first();
    }
}