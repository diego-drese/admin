<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PermissionCollection;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;

class PermissionController extends Controller {
    public function index(Request $request) {
        $limit = $request->has('limit') ? $request->get('limit') : null;
        return new PermissionCollection(Permission::paginate($limit));
    }

    public function show(int $id) {
        return new PermissionResource(Permission::find($id));
    }

}
