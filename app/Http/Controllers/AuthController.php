<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Jobs\SendEmailJob;
use App\Mail\PasswordReset;
use App\Models\PasswordResetToken;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller {
    public function register(RegisterRequest $request): JsonResponse {
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        if ($user->save()) {
            return response()->json([
                'message' => 'Successfully created user!'
            ], 201);
        } else {
            return response()->json(['error' => 'Provide proper details']);
        }
    }

    public function login(LoginRequest $request): JsonResponse {
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }


    public function logout(Request $request): JsonResponse {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function me(Request $request): JsonResponse {
        return response()->json($request->user());
    }

    public function root(Request $request): JsonResponse {
        return response()->json(['me'=>$request->user(),'root'=>true]);
    }
    public function user(Request $request): JsonResponse {
        return response()->json(['me'=>$request->user(),'root'=>false, 'user'=>true]);
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse {
        $user = User::getByEmail($request->get('email'));
        if ($user) {
            $token = PasswordResetToken::create([
                'email' => $user->email,
                'token' => md5(uniqid()),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $job = new SendEmailJob(new PasswordReset($token), $user->email);
            dispatch($job->onQueue(Config::get('queue.email')));
        }
        return response()->json([
            'message' => 'Email sent successfully, follow the instructions in your email box.'
        ]);
    }

    public function newPassword(ResetPasswordRequest $request): JsonResponse {
        $token = PasswordResetToken::getByToken($request->get('token'));
        if (!$token) {
            return response()->json([
                'message' => 'Token invalid'
            ]);
        }
        $user = User::getByEmail($token->email);
        $user->password = Hash::make($request->get('password'));
        $user->save();

        $token->used_at = date('Y-m-d H:i:s');
        $token->deleted_at = date('Y-m-d H:i:s');
        $token->save();
        return response()->json([
            'message' => 'Password changed successfully'
        ]);
    }
}