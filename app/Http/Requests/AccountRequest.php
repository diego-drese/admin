<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\Models\Account;

class AccountRequest extends FormRequest {

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
            'company' => 'required',
            'email' => 'required',
            'country_id' => 'required|numeric|min:1'
        ];
    }
    public function withValidator($validator) {
        $validator->after(function ($validator) {
            if(Account::hasEmail($this->get('email'), $this->get('id'))){
                $validator->errors()->add('email', 'Email already exists.');
            }
        });
    }

}
