<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LanguageRequest;
use App\Http\Resources\LanguageCollection;
use App\Http\Resources\LanguageResource;
use App\Models\Language;

class LanguageController extends Controller {
    public function index(Request $request) {
        $limit = $request->has('limit') ? $request->get('limit') : null;
        return new LanguageCollection(Language::paginate($limit));
    }

    public function store(LanguageRequest $request) {
        return new LanguageResource(Language::create($request->all()));
    }

    public function show(int $id) {
        return new LanguageResource(Language::find($id));
    }

    public function update(LanguageRequest $request, int $id) {
        $language = Language::find($id);
        $language->update($request->all());
        return new LanguageResource($language);
    }


}