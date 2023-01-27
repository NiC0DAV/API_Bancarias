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
            'orderId' => 'required',
            'financialCode' => 'required'
        ]);

        if ($validate->fails()) {
            $response = array(
                'errorCode' => '400',
                'errorDescription' => 'Sintaxis invalida, verifique los datos ingresados e intentelo nuevamente',
                'traceId' => '400'
            );
            $statusCode = '400';
        } else {

            try {
                    $orderId =  $request->input('orderId');
                    $financialCode = $request->input('financialCode');

                    $consultOrderId =  FN_CREDITINSCRIPTION::where([
                        'orderId' => $orderId,
                        'financialCode' => $financialCode
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

                        $statusCode = '200';

                        if($consultOrderId->status == 'APPROVED'){
                            $response = array(
                                'statusCode' => $consultOrderId->status,
                                'amount'  => $newTotal,
                                'causalRejection' => $consultOrderId->causalRejection,
                                'paymentConfirmationDate'   => $consultOrderId->created_at,
                                'financialCode' =>  $consultOrderId->financialCode,
                                'channelCode'   => $consultOrderId->channelCode,
                                'financialOrderId' => $consultOrderId->orderId
                            );
                        }elseif($consultOrderId->status == 'DECLINED' || $consultOrderId->status == 'ABORTED' || $consultOrderId->status == 'ABANDONED'){
                            $response = array(
                                'statusCode' => $consultOrderId->status,
                                'causalRejection' => $consultOrderId->causalRejection,
                                'amount'  => $newTotal,
                                'paymentConfirmationDate'   => $consultOrderId->created_at,
                                'financialCode' =>  $consultOrderId->financialCode,
                                'channelCode'   => $consultOrderId->channelCode,
                                'financialOrderId' => $consultOrderId->orderId
                            );
                        }else{
                            $response = array(
                                'statusCode' => 'PENDING',
                                'causalRejection' => $consultOrderId->causalRejection,
                                'amount'  => $newTotal,
                                'paymentConfirmationDate'   => $consultOrderId->created_at,
                                'financialCode' =>  $consultOrderId->financialCode,
                                'channelCode'   => $consultOrderId->channelCode,
                                'financialOrderId' => $consultOrderId->orderId
                            );
                        }


                    } else {

                        $statusCode = '404';
                        $response = array(
                            'errorCode' => '404',
                            'errorDescription' => 'OrderId no encontrado',
                            'traceId' => '404'
                        );
                    }
            } catch (\Throwable $th) {
                $statusCode = '404';
                $response = array(
                    'errorCode' => '404',
                    'errorDescription' => 'OrderId no encontrado',
                    'traceId' => '404'
                );
            }
        }

        return response()->json($response, $statusCode);
    }
}
