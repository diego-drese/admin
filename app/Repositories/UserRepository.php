<?php

namespace App\Repositories;

use App\Jobs\SendEmailJob;
use App\Mail\PasswordReset;
use App\Models\PasswordResetToken;
use App\Models\User;
use Illuminate\Database\QueryException;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Http\Response as ResponseHttp;

class UserRepository implements RepositoryInterface {
    private $model;

    public function __construct(User $model) {
        $this->model = $model;
    }

    public function find($id) {
        return $this->model->with('roles')->find($id);
    }

    public function paginate(Request $request) {
        return $this->model->paginate($request->get('limit', 10));
    }

    public function add(array $data) {
        $user = $this->model->create(['name' => $data['name'], 'email' => $data['email'], 'password'=>bcrypt($data['password'])]);
        $user->roles()->sync($data['roles']);
        return $this->find($user->id);
    }

    public function update(array $data, $id) {
        $user = $this->find($id);
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->roles()->sync($data['roles']);
        $user->save();
        return $this->find($id);
    }

    public function destroy($id) {
        $user = $this->find($id);
        if ($user) {
            try {
                $user->delete();
                return ['message' => 'User deleted successfully'];
            } catch (QueryException $e) {
                return ['message' => $e->getMessage(), 'status_code'=> ResponseHttp::HTTP_INTERNAL_SERVER_ERROR];
            }
        }
        return ['message' => 'User not found'];
    }

    public function register($data): User {
        return $this->model->create(['name' => $data['name'], 'email' => $data['email'], 'password'=>bcrypt($data['password'])]);
    }

    public function updateMe(Request $request): User {
        $user           = $request->user();
        $user->name     = $request->get('name');
        $user->email    = $request->get('email');
        if($request->get('password')){
            $user->password    = bcrypt($request->get('password'));
        }
        $user->save();
        return $user;
    }

    public function login(Request $request): array {
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return ['message' => 'Unauthorized', 'status_code'=>401];
        }
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        return ['access_token' => $tokenResult->plainTextToken, 'token_type' => 'Bearer'];
    }

    public function logout(Request $request): array {
        $request->user()->tokens()->delete();
        return ['message' => 'Successfully logged out'];
    }

    public function resetPassword(Request $request): array {
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
        return ['message' => 'Email sent successfully, follow the instructions in your email box.'];
    }

    public function newPassword(Request $request): array {
        $token = PasswordResetToken::getByToken($request->get('token'));
        if (!$token) {
            return ['message' => 'Token invalid', 'status_code' => ResponseHttp::HTTP_UNAUTHORIZED];
        }
        $user = User::getByEmail($token->email);
        $user->password = Hash::make($request->get('password'));
        $user->save();

        $token->used_at = date('Y-m-d H:i:s');
        $token->deleted_at = date('Y-m-d H:i:s');
        $token->save();
        return ['message' => 'Password changed successfully'];
    }

    public function hasEmail($email) {
        return $this->model->where('email', $email)->first();
    }
}