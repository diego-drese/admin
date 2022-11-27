<?php
namespace App\Http\Controllers;

use App\Http\Requests\AccountChangeRequest;
use App\Models\User;
use App\Http\Requests\AccountRequest;
use App\Http\Requests\AccountRequestStore;
use App\Http\Resources\AccountCollection;
use App\Http\Resources\AccountResource;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\UserAccount;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller {
    public function index(Request $request) {
        $limit  = $request->has('limit') ? $request->get('limit') : null;
        $user   = Auth::user();
        $data   = Account::query();
        $data->noRoot($user);
        if($request->search){
            $data->where('email', $request->search)
                ->orWhere('company', 'like', '%' . $request->search . '%');
        }
        return new AccountCollection($data->paginate($limit));
    }
    public function storeSave(Request $request){
        $account = new Account();
        $account->fill($request->only($account->getFillable()))->save();
        $userdata= [
            'name'              => $request->get('name'),
            'email'             => $request->get('email'),
            'password'          => $request->get('password'),
            'language_id'       => $request->get('language_id'),
            'account_id'        => $account->id,
            'is_account_root'   => 1
        ];

        $user = User::create($userdata);
        UserAccount::attach($user, $account, Role::getDefaultRootAccount());
        $credentials = $request->only('email', 'password');
        if (!auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $token = auth()->user()->createToken('token-by-campaign');
        return response()->json([
            'access_token' => $token->plainTextToken,
            'token_type' => 'bearer',
            'user'=> Auth::user()
        ]);
    }

    public function store(AccountRequestStore $request) {
        if($request->has('check')){
            return new AccountResource($request);
        }
       return $this->storeSave($request);
    }

    public function show(int $id) {
        $user = Auth::user();
        $data = Account::query();
        $data->noRoot($user);
        return new AccountResource($data->find($id));
    }

    public function update(AccountRequest $request, int $id) {
        $user = Auth::user();
        $data = Account::query();
        $data->noRoot($user);
        $account = $data->find($id);
        $account->update($request->all());
        return new AccountResource($account);
    }

    public function change(AccountChangeRequest $request, int $accountId) {
        $user = Auth::user();
        $user->account_id = $accountId;
        $user->save();
        return response()->json([
            'success' => true,
            'message' => 'success'
        ]);
    }
}
