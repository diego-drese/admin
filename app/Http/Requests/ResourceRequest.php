<?php

namespace App\Http\Requests;

use App\Models\Resource;
use App\Repositories\ResourceRepository;
use Illuminate\Foundation\Http\FormRequest;

class ResourceRequest extends FormRequest {

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
            'description' => 'required|string',
            'parent_id'=> 'nullable|integer',
            'order'=> 'nullable|integer',
        ];

    }

    public function withValidator($validator) {
        $validator->after(function ($validator) {
            $roleRepository = new ResourceRepository(new Resource());
            $hasName = $roleRepository->hasName($this->get('name'));
            if($hasName){
                if((int)$hasName->id != (int)$this->id){
                    $validator->errors()->add('name', 'Name already exists.');
                }
            }
        });
    }
}
