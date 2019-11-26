<?php

namespace App\Modules\Localisation\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestCity extends FormRequest
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
            'name_city'=>'unique:cities,name_city',
            'code'=>'unique:cities,code'
        ];
    }
    public function messages()
    {
        return [
            'name_city.unique'=>'Tên thành phố đã bị chùng!',
            'code.unique'=>'Tên viết tắt đã bị chùng!'
        ];
    }
}
