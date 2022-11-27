<?php
namespace App\Http\Requests;

use App\Models\UserAccount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountChangeRequest extends FormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request) {
        return [];
    }

    public function withValidator($validator) {
        $validator->after(function ($validator) {
            $user = Auth::user();
            if(!$user->is_root){
                if(!UserAccount::getByUserAndAccount($user->id, $this->accountId)){
                    $validator->errors()->add('accountId', "Account don't exists.");
                }
            }
        });
    }
}
