<?php

namespace App\Modules\Localisation\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestCountry extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'unique:countries,name',
            'code'=>'unique:countries,code',
            'dial_code'=>'unique:countries,dial_code'
        ];
    }
    public function messages()
    {
        return [
            'name.unique'=>'Tên quốc gia đã bị chùng!',
            'code.unique'=>'Tên viết tắt đã bị chùng!',
            'dial_code.unique'=>'Mã vùng đã bị chùng!'
        ];
    }
}
