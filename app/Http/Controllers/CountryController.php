<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CountryRequest;
use App\Http\Resources\CountryCollection;
use App\Http\Resources\CountryResource;
use App\Models\Country;

class CountryController extends Controller {
    public function index(Request $request) {
        $limit = $request->has('limit') ? $request->get('limit') : null;
        return new CountryCollection(Country::paginate($limit));
    }

    public function store(CountryRequest $request) {
        return new CountryResource(Country::create($request->all()));
    }

    public function show(int $roleId) {
        return new CountryResource(Country::find($roleId));
    }

    public function update(CountryRequest $request, int $roleId) {
        $role = Country::find($roleId);
        $role->update($request->all());
        return new CountryResource($role);
    }
}