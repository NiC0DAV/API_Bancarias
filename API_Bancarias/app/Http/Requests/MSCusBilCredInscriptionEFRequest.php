<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MSCusBilCredInscriptionEFRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'financialCode'           =>    'required',
            'totalAmount'             =>    'required|numeric|digits_between:4,8',
            'shippingAmount'          =>    'required|numeric',
            'totalTaxesAmount'        =>    'required|numeric',
            'currency'                =>    'required',
            'documentType'            =>    'required|numeric',
            'documentNumber'          =>    'required',
            'firstName'               =>    'required',
            'lastName'                =>    'required',
            'email'                   =>    'required|email',
            'mobileNumber'            =>    'required',
            'mobileNumberCountryCode' =>    'required'
        ];
    }
}
