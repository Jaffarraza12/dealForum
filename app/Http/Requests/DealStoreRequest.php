<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class DealStoreRequest extends FormRequest
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
            'name' => 'required',
            'description' => 'required',
            'discount' => 'required|numeric',
            'company' => 'required|numeric',
        ];
    }

     public function messages()

    {

        return [

            'company.numeric' => 'The company should be selected',

        ];

    }
}
