<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponUpdateRequest extends FormRequest
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
            'company'  => 'required',
            'deal'  => 'required|numeric',
            'limit'  => 'required|numeric||max:1000', 
            'code'  => 'required|size:5|unique:coupon,code,'.$this->route('coupon'),


        ];
    }

     public function messages()
    {

        return [

            'deal.numeric' => 'The Deal name should be selected',

        ];

    }
}
