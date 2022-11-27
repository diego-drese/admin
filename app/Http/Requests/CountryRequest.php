<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CountryRequest extends FormRequest {

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
            'iso' => 'required',
            'time_zone' => 'required',
            'minimum_size_phone' => 'required|numeric|min:1|max:20',
            'maximum_size_phone' => 'required|numeric|min:1|max:20',
            'ddi' => 'required|numeric',
            'status' => 'required|numeric|min:0|max:1'
        ];
    }
    public function withValidator($validator) {
        $validator->after(function ($validator) {
            if ($this->get('maximum_size_phone') <= $this->get('minimum_size_phone')) {
                $validator->errors()->add('maximum_size_phone', 'The max size number must be greater than the minimum');
            }
        });
    }

}
