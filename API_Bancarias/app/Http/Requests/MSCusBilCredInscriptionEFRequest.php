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
            'channelCode'                    =>    'required',
            'financialCode'                  =>    'required|digits_between:1,8',
            'orderId'                        =>    'required',
            'purchaseDescription'            =>    'required',
            'totalAmount'                    =>    'required|numeric',
            'shippingAmount'                 =>    'required|numeric',
            'totalTaxesAmount'               =>    'required|numeric',
            'currency'                       =>    'required',
            'client'                         =>    'required|array:documentType,documentNumber,firstName,lastName,email,mobileNumber,mobileNumberCountryCode',
            'client.documentType'            =>    'required|numeric',
            'client.documentNumber'          =>    'required',
            'client.firstName'               =>    'required',
            'client.lastName'                =>    'required',
            'client.email'                   =>    'required|email',
            'client.mobileNumber'            =>    'required',
            'client.mobileNumberCountryCode' =>    'required',
            'redirectionUrl'                 =>    'required'
        ];
    }
}
