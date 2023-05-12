<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
             'name' => 'required|string',
            'price' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return[
            'name.required'=> "အမည်ထည့်ရန်လိုအပ်သည်။",
            'name.string'=> "အမည် စာသားဖြစ်ရမည်။",
            'price.required'=> "ဈေးနှုန်း ထည့်ရန်လိုအပ်သည်။",
            'price.numeric'=> "ဈေးနှုန်း နံပါတ်ဖြစ်ရမည်။"
        ];
    }
}
