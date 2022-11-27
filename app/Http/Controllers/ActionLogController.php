<?php
namespace App\Http\Controllers;

use App\Http\Resources\ActionLogCollection;
use App\Http\Resources\ActionLogResource;
use App\Models\ActionLog;
use Illuminate\Http\Request;

class ActionLogController extends Controller {
    public function index(Request $request) {
        $limit = $request->has('limit') ? $request->get('limit') : null;
        return new ActionLogCollection(ActionLog::paginate($limit));
    }

    public function show(int $id) {
        return new ActionLogResource(ActionLog::find($id));
    }


}