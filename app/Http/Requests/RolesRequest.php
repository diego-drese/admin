<?php

namespace App\Http\Requests;

use App\Models\Role;
use App\Repositories\RoleRepository;
use Illuminate\Foundation\Http\FormRequest;

class RolesRequest extends FormRequest {

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
            'status' => 'required|min:0|max:1',
            'resources'=> 'required|array',
            'resources.*'=> 'integer|distinct|min:0'
        ];
    }

    public function withValidator($validator) {
        $validator->after(function ($validator) {
            $roleRepository = new RoleRepository(new Role());
            $hasName = $roleRepository->hasName($this->get('name'));
            if($hasName){
                if((int)$hasName->id != (int)$this->id){
                    $validator->errors()->add('name', 'Name already exists.');
                }
            }
        });
    }
}
