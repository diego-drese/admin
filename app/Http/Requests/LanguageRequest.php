<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\Models\Language;

class LanguageRequest extends FormRequest {

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
            'code' => 'required',
            'icon' => 'required',
            'status' => 'required|numeric|min:0|max:1',
            'default' => 'required|numeric|min:0|max:1'
        ];
    }
    public function all($keys = null) {
        $data = parent::all();
        if($this->route('id')){
            $data['id'] = $this->route('id');
        }
        return $data;
    }

    public function withValidator($validator) {
        $validator->after(function ($validator) {
            $fields = $this->all();
            if($fields['default']==0 && isset($fields['id'])){
                $default = Language::getDefault();
                if($default->id == $fields['id']){
                    $validator->errors()->add('default', 'Unable to mark as non-default');
                }

            }
        });
    }
}
