<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompaniesStoreRequest extends FormRequest
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
            'slug' => 'required|unique:companies',
            'name' => 'required',
            'category' => 'required|numeric',
        ];
    }



    public function messages()

    {

        return [

            'category.numeric' => 'Catgory Should be Selected',

        ];

    }
}
