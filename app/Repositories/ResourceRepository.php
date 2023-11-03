<?php

namespace App\Repositories;

use App\Models\Resource;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ResourceRepository implements RepositoryInterface {
    private $model;

    public function __construct(Resource $model) {
        $this->model = $model;
    }

    public function find($id) {
        return $this->model->find($id);
    }

    public function paginate(Request $request) {
        return $this->model->orderBy('order', 'ASC')->orderBy('name', 'ASC')->paginate($request->get('limit', 10));
    }

    public function add(array $data) {
        return $this->model->create(['name' => $data['name'], 'is_menu' => $data['is_menu'], 'parent_id' => $data['parent_id'], 'order' => $data['order']]);
    }

    public function update(array $data, $id) {
        $this->model->where('id', $id)->update(['name' => $data['name'], 'is_menu' => $data['is_menu'], 'parent_id' => $data['parent_id'], 'order' => $data['order']]);
        return $this->find($id);
    }

    public function destroy($id) {
        $role = $this->find($id);
        if ($role) {
            try {
                $role->delete();
                return ['message' => 'Resource deleted successfully'];
            }catch (QueryException $e){
                return ['message' => $e->getMessage()];
            }
        }
        return ['message' => 'Resource not found'];
    }

    public function hasName($name) {
        return $this->model->where('name', $name)->first();
    }
}