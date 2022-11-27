<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {
    public function index(Request $request) {
        $user   = Auth::user();
        if($user->is_root){
            $limit = $request->has('limit') ? $request->get('limit') : null;
            return new UserCollection(User::paginate($limit));
        }
        return new UserCollection([]);
    }
}