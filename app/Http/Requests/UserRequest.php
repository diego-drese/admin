<?php
namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRequest extends FormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request) {
        return [
            'email' => 'required|email',
            'password' => 'required',
            'new_password' => 'nullable|confirmed|different:password',
            'new_password_confirmation' => 'nullable',
        ];
    }

    public function withValidator($validator) {
        $validator->after(function ($validator) {
            if ($this->has('password') && !Hash::check($this->password, Auth::user()->password)) {
                $validator->errors()->add('password', 'Invalid password');
            }

            if(User::checkEmailExist($this->get('email'),  Auth::user()->id)){
                $validator->errors()->add('email', 'Invalid email.');
            }

            if($this->has('new_password') && $this->get('new_password')!=''){
                $this->merge(['password'=> $this->get('new_password')]);
            }

        });
    }
}
