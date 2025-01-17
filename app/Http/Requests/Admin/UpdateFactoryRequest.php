<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFactoryRequest extends FormRequest
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
            //
            'NAME' =>'required', 
            'ADDRESS' =>'required',
            'CITY' =>'required',
            'COUNTRY' =>'required',
            'MAIL' =>'required',
            'accounting_vats_id' =>'required',
            'curency' =>'required',
            'add_day_validity_quote' =>'required',
            'add_delivery_delay_order'  =>'required',
        ];
    }
}
