<?php

namespace App\Http\Controllers;

use App\Http\Requests\MSCusBilCredInscriptionEFRequest;
use App\Models\CreditSimulate;
use App\Models\FN_CREDITINSCRIPTION;
use Illuminate\Support\Facades\Validator;
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

        $checkClient = CreditSimulate::where([
            'documentNumber' => $docNum
        ])->latest()->first();

        $validate = Validator::make($paramsArr, [
            'orderId' => 'required|unique:FN_CREDITINSCRIPTIONS'
        ]);

        if ($validate->fails()) {
            $return = array(
                'errorCode' => '404',
                'errorDescription' => 'El orderId ingresado ya se encuentra asociado a un financiamiento.',
                'traceId' => '404'
            );
        } elseif (!$validate->fails() && $checkClient->validToFinance == 1) {
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
            $creditInscription->mobileNumber = $payloadParse->client->mobileNumber;
            $creditInscription->mobileNumberCountryCode = $payloadParse->client->mobileNumberCountryCode;
            $creditInscription->redirectionUrl = $payloadParse->redirectionUrl;
            $creditInscription->inscriptionId = $inscriptionId;
            $creditInscription->save();

            $return = array('inscriptionId'   => $inscriptionId);
        }

        return $return;
    }
}
