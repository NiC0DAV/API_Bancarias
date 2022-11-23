<?php

namespace App\Http\Controllers;

use App\Models\CreditSimulate;
use App\Models\FN_CREDITINSCRIPTION;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FinanceValidateController extends Controller
{
    function MSCusBilCredValidateEF(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'orderId' => 'required'
        ]);

        if ($validate->fails()) {

            $response = array('status' => '400');
        } else {

            $orderId =  $request->input('orderId');

            $consultOrderId =  FN_CREDITINSCRIPTION::where([
                'orderId' => $orderId
            ])->latest()->first();

            if (is_object($consultOrderId)) {

                $dataClient =  CreditSimulate::where('documentNumber', $consultOrderId['clientDocNumber'])->latest()->first();
                if ($dataClient['guaranteeRate'] > 0) {
                    $interestPercentage = ($dataClient['guaranteeRate'] / 100);
                    $calcGuarranteeRate = $consultOrderId['totalAmount'] * $interestPercentage;
                    $newTotal = $consultOrderId['totalAmount'] - $calcGuarranteeRate;
                } else {
                    $newTotal = $consultOrderId['totalAmount'];
                }

                $response = array(
                    'statusCode' => '200',
                    'code' => 200,
                    'message' => 'Successful Response',
                    'amount'  => $newTotal,
                    'paymentConfirmationDate'   => $consultOrderId->created_at,
                    'financialCode' =>  $consultOrderId->financialCode,
                    'channelCode'   => $consultOrderId->chanelCode,
                    'financialOrderId' => $consultOrderId->orderId
                );
            } else {

                $response = array(
                    'statusCode' => '404',
                    'code' => 404,
                    'message' => 'OrderId NotFound',

                );
            }
        }

        return response()->json($response, $response['statusCode']);
    }
}
