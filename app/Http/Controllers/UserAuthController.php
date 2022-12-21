<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\Account;

class UserAuthController extends Controller {
    public function show(): JsonResource {
        return new UserResource(Auth::user());
    }

    public function update(UserRequest $request): JsonResource {
        $user = Auth::user();
        $user->update($request->all());
        return new UserResource($user->makeHidden(['is_root']));
    }

    public function updateUserAndCompany(Request $request) {
        $user = Auth::user();
        Account::updateById($user->account_id, $request);
        Cache::tags([Config::get('BoilerplateAdmin.cache_tag')])
            ->forget('App\Models\UsergetAccountsAttribute-user-'.$user->id);
        $user->update($request->all());

        return response()->json([
            'user' => $user,
            'message' => 'ok'
        ]);
    }

}
