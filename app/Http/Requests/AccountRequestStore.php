<?php
namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\Models\Account;

class AccountRequestStore extends FormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request) {
        if($request->method=='GET'){
            return [];
        }

        return [
            'name' => 'required',
            'email' => 'required',
            'language_id' => 'required|numeric|min:1',
            'country_id' => 'required|numeric|min:1',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ];
    }
    public function withValidator($validator) {
        $validator->after(function ($validator) {
            if(Account::hasEmail($this->get('email'), $this->get('id'))){
                $validator->errors()->add('email', 'Account Email already exists.');
            }

            if(User::checkEmailExist($this->get('email'))){
                $validator->errors()->add('email', 'User Email already exists.');
            }
        });
    }

}
