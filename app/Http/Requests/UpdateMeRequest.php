<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UpdateMeRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|email',
            'current_password' => 'required|string',
            'password' => 'string|nullable',
            'c_password' => 'string|same:password|nullable',
        ];
    }
    public function withValidator($validator) {
        $validator->after(function ($validator) {
            $userRepository = new UserRepository(new User());
            $user = $this->user();

            if($user->is_root){
                $validator->errors()->add('email', "This user cannot be edited");
            }

            if(!Hash::check($this->get('current_password'), $user->password)){
                $validator->errors()->add('current_password', "Passwords current don't match");
            }

            $hasEmail = $userRepository->hasEmail($this->get('email'));
            if($hasEmail && (int)$hasEmail->id != (int)$user->id){
                $validator->errors()->add('email', 'Email already exists.');
            }
        });
    }

}









