<?php

namespace App\Http\Controllers;

use App\Http\Requests\MSCusBilCredInscriptionEFRequest;
use App\Models\CreditSimulate;
use App\Models\FN_CREDITINSCRIPTION;
use Illuminate\Http\Request;

class CreditInscriptionController extends Controller
{

    public function MSCusBilCredInscriptionEF(MSCusBilCredInscriptionEFRequest $request)
    {
        $payload = $request->getContent();
        $payloadParse = json_decode($payload);
        $unixTime = strtotime('now');

        $docNum = $payloadParse->client->documentNumber;

        $checkClient = CreditSimulate::where([
            'documentNumber' => $docNum
        ])->latest()->first();

        if ($checkClient->validToFinance == 1) {
            $inscriptionId = base64_encode($unixTime . $docNum);
            $newCausalRejection = $checkClient->causalRejection !== '' ? $checkClient->causalRejection : $this->unique_code(9);
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
            $creditInscription->causalRejection = $newCausalRejection;
            $creditInscription->mobileNumber = $payloadParse->client->mobileNumber;
            $creditInscription->mobileNumberCountryCode = $payloadParse->client->mobileNumberCountryCode;
            $creditInscription->redirectionUrl = $payloadParse->redirectionUrl;
            $creditInscription->inscriptionId = $inscriptionId;
            $creditInscription->save();
        }

        return [
            'inscriptionId'   => $inscriptionId,
        ];
    }

    function unique_code($limit){
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }
}
