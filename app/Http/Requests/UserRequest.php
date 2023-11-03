<?php

namespace App\Http\Requests;

use App\Models\Role;
use App\Models\User;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'name' => 'required|string',
            'roles'=> 'required|array',
            'roles.*'=> 'integer|distinct|min:0'
        ];
    }

    public function withValidator($validator) {
        $validator->after(function ($validator) {
            if(!empty($this->id)){
                if($this->get('password')!=$this->get('c_password')){
                    $validator->errors()->add('password', "Passwords don't match");
                }
            }elseif($this->get('password') && $this->get('password')!=$this->get('c_password')){
                $validator->errors()->add('password', "Passwords don't match");
            }
            $userRepository = new UserRepository(new User());
            $hasEmail = $userRepository->hasEmail($this->get('email'));
            if($hasEmail && (int)$hasEmail->id != (int)$this->id){
                $validator->errors()->add('name', 'Email already exists.');
            }
        });
    }
}
