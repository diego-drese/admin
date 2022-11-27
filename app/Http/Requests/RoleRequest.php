<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class RoleRequest extends FormRequest {

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
            'status' => 'required|numeric|min:0|max:1',
            'description' => '',
            'is_admin' => 'required|numeric|min:0|max:1',
            'permission'=> 'required|array',
            'permission.*'=> 'integer|distinct|min:0'
        ];
    }
}
