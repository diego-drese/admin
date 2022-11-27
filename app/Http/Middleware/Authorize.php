<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\Permission;

class Authorize {
    use AuthorizesRequests;

    public function handle(Request $request, Closure $next) {
        $auth = app('auth');
        $method = $request->method();
        $uri = $request->route()->uri;
        if (!$auth) {
            return response()->json(['message' => 'User is not logged in.'], 401);
        }

        $permission = Permission::getPermission($method, $uri);
        if(!$permission){
            return response()->json(['message' => 'Permission not found'], 401);
        }

        if(!$auth->user()->hasPermission($permission)){
            return response()->json(['message' => 'User does not have the right permissions.'], 401);
        }

        return $next($request);
    }
}