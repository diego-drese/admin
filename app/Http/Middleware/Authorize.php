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
            return response()->json(['message' => 'Usuário não esta logado'], 401);
        }
        $user = $auth->user();
        if (!$user->is_root && !$user->email_check_at) {
            return response()->json(['message' => 'Você precisa confirmar seu email.'], 401);
        }

        $permission = Permission::getPermission($method, $uri);
        if(!$permission){
            return response()->json(['message' => 'Permission not found'], 401);
        }

        if(!$user->hasPermission($permission)){
            return response()->json(['message' => 'User does not have the right permissions.'], 401);
        }

        return $next($request);
    }
}