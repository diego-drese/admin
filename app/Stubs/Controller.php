<?php
namespace App\Http\Controllers;

use Aggrega\BoilerplateAdmin\Http\Requests\MODEL_NAMERequest;
use Aggrega\BoilerplateAdmin\Http\Resources\MODEL_NAMECollection;
use Aggrega\BoilerplateAdmin\Http\Resources\MODEL_NAMEResource;
use Aggrega\BoilerplateAdmin\Models\MODEL_NAME;
use Illuminate\Http\Request;

class MODEL_NAMEController extends Controller {
    public function index(Request $request) {
        $limit = $request->has('limit') ? $request->get('limit') : null;
        return new MODEL_NAMECollection(MODEL_NAME::paginate($limit));
    }

    public function store(MODEL_NAMERequest $request) {
        return new MODEL_NAMEResource(MODEL_NAME::create($request->all()));
    }

    public function show(int $id) {
        return new MODEL_NAMEResource(MODEL_NAME::find($id));
    }

    public function update(MODEL_NAMERequest $request, int $id) {
        $account = MODEL_NAME::find($id);
        $account->update($request->all());
        return new MODEL_NAMEResource($account);
    }
}