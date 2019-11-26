<?php

namespace App\Modules\Localisation\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestEditCountry extends FormRequest
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
            'name'=>'unique:countries,name,'.$this->segment(5).',id',
            'code'=>'unique:countries,code,'.$this->segment(5).',id',
            'dial_code'=>'unique:countries,dial_code,'.$this->segment(5).',id'
        ];
    }

    public function messages()
    {
        return [
            'name.unique'=>'Tên quốc gia đã bị chùng!',
            'code.unique'=>'Tên viết tắt đã bị chùng!',
            'dial_code.unique'=>'Mã quốc gia đã bị chùng!'
        ];
    }
}
