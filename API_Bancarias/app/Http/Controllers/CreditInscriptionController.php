<?php

namespace App\Http\Controllers;

use App\Http\Requests\MSCusBilCredInscriptionEFRequest;
use App\Models\CreditSimulate;
use App\Models\FN_CREDITINSCRIPTION;
use Illuminate\Support\Facades\Validator;

use App\Models\StatusFinanceForEmail;

use Illuminate\Http\Request;

class CreditInscriptionController extends Controller
{

    public function MSCusBilCredInscriptionEF(MSCusBilCredInscriptionEFRequest $request)
    {
        $payload = $request->getContent();
        $payloadParse = json_decode($payload);
        $unixTime = strtotime('now');
        $paramsArr = ['orderId' => $payloadParse->orderId];

        $docNum = $payloadParse->client->documentNumber;

        $checkStatus = $this->checkIfIsvalidToFinance($payloadParse->client->email);


        $validate = Validator::make($paramsArr, [
            'orderId' => 'required|unique:FN_CREDITINSCRIPTIONS'
        ]);

        if ($validate->fails()) {
            $return = array(
                'errorCode' => '400',
                'errorDescription' => 'El orderId ingresado ya se encuentra asociado a un financiamiento.',
                'traceId' => '404'
            );
        } elseif (!$validate->fails() && boolval($checkStatus['validToFinance'])) {

            $inscriptionId = base64_encode($unixTime . $docNum);

            $creditInscription = new FN_CREDITINSCRIPTION();
            $creditInscription->channelCode = $payloadParse->channelCode;
            $creditInscription->financialCode = $payloadParse->financialCode;
            $creditInscription->orderId = $payloadParse->orderId;
            $creditInscription->purchaseDescription = $payloadParse->purchaseDescription;
            $creditInscription->totalAmount = $payloadParse->totalAmount;
            $creditInscription->shippingAmount = $payloadParse->shippingAmount;
            $creditInscription->totalTaxesAmount = $payloadParse->totalTaxesAmount;
            $creditInscription->currency = $payloadParse->currency;
            $creditInscription->clientDocType = $payloadParse->client->documentType;
            $creditInscription->clientDocNumber = $payloadParse->client->documentNumber;
            $creditInscription->firstName = $payloadParse->client->firstName;
            $creditInscription->lastName = $payloadParse->client->lastName;
            $creditInscription->email = $payloadParse->client->email;
            $creditInscription->causalRejection = '';
            if ($payloadParse->client->email == 'approved@claro.com.co') {
                $creditInscription->status = 'APPROVED';
                $creditInscription->causalRejection = $this->unique_code(9);
                $creditInscription->cuotas = 12;
            }
            $creditInscription->mobileNumber = $payloadParse->client->mobileNumber;
            $creditInscription->mobileNumberCountryCode = $payloadParse->client->mobileNumberCountryCode;
            $creditInscription->redirectionUrl = $payloadParse->redirectionUrl;
            $creditInscription->inscriptionId = $inscriptionId;
            $creditInscription->save();

            $return = array('inscriptionId'   => $inscriptionId);

        }else{
            $return = array(
                'errorCode' => 'L407',
                'errorDescription' => 'No es posible financiar el cliente en este momento.',
                'traceId' => 'L407'
            );
        }

        return $return;
    }

    private function checkIfIsvalidToFinance($email)
    {
        $financeData = StatusFinanceForEmail::where('email', $email)->first();
        if (!$financeData) {
            return [
                'validToFinance'   => false,
                'guaranteeRate'    => 0,
                'causalRejection'  => 'No es posible financiar el cliente en este momento.'
            ];
        }
        return [
            'validToFinance'   => $financeData['response_status'],
            'guaranteeRate'    => $financeData['guaranteeRate'],
            'causalRejection'  => $financeData['causalRejection']
        ];

    }

    function unique_code($limit){
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }
}
