<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class MODEL_NAMERequest extends FormRequest {

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


        ];
    }
    public function withValidator($validator) {
        $validator->after(function ($validator) {

        });
    }

}
