<?php

namespace App\Modules\Localisation\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestEditCity extends FormRequest
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
            'name_city'=>'unique:cities,name_city,'.$this->segment(5).',id',
            'code'=>'unique:cities,code,'.$this->segment(5).',id'
        ];
    }
    public function messages()
    {
        return [
            'name_city.unique'=>'Tên tỉnh/thành phố đã bị chùng!',
            'code.unique'=>'Tên viết tắt đã bị chùng!',
        ];
    }
}
