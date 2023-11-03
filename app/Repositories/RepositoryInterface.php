<?php

namespace App\Repositories;

use App\Models\Role;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

interface RepositoryInterface {
    public function find(int $id);

    public function paginate(Request $request);

    public function add(array $data);

    public function update(array $data, int $id);

    public function destroy(int $id);
}