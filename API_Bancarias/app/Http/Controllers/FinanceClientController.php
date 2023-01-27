<?php

namespace App\Http\Controllers;

use App\Models\CreditSimulate;
use App\Models\FN_CREDITINSCRIPTION;
use App\Models\StatusFinanceForEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FinanceClientController extends Controller
{
    public function financeService(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'inscriptionId' => 'required'
        ]);
        if ($validate->fails()) {
            echo "falta inscriptionId";
            exit();
        }
        $inscriptionId = $request->input('inscriptionId');
        $dataClient = FN_CREDITINSCRIPTION::where('inscriptionId', $inscriptionId)->first();
        $dataClientDoc = CreditSimulate::where('documentNumber', $dataClient['clientDocNumber'])->latest()->first();
        if ($dataClientDoc['guaranteeRate'] > 0) {
            $interestPercentage = ($dataClientDoc['guaranteeRate'] / 100);
            $calcGuarranteeRate = $dataClient['totalAmount'] * $interestPercentage;
            $newTotal = $dataClient['totalAmount'] - $calcGuarranteeRate;
            $response = view('financeClient.finance')->with('dataClient', $dataClient)->with('newTotal', $newTotal);
        } else {
            $newTotal = $dataClient['totalAmount'];
            $response = view('financeClient.finance')->with('dataClient', $dataClient)->with('newTotal', $newTotal);
        }

        return $response;
    }

    public function financeServiceUpdate(FN_CREDITINSCRIPTION $dataClient, Request $request)
    {
        $request->validate([
            'dues' => 'required|numeric',
        ]);

        $dues = $request->input('dues');
        $checkStatus = $this->checkIfIsvalidToFinance($dataClient->email);
        if (boolval($checkStatus['validToFinance'])) {
            $status = 'APPROVED';
            $causalRejection = $this->unique_code(9);
        } else {
            $status = 'DECLINED';
            $causalRejection = 'The client is not valid to finance.';
        }
        // $status = ['APPROVED', 'PENDING', 'REJECTED', 'ABANDONED', 'DECLINED'];
        // $randStatus = $status[mt_rand(0, count($status) - 1)];
        $dataClient->cuotas = $dues;
        $dataClient->status = $status;
        $dataClient->causalRejection = $causalRejection;
        $dataClient->update();

        $response = view('financeClient.resultFinance')->with('dataClient', $dataClient);

        return $response;
    }


    private function checkIfIsvalidToFinance($email)
    {
        $financeData = StatusFinanceForEmail::where('email', $email)->first();
        if (!$financeData) {
            return [
                'validToFinance'   => false,
                'guaranteeRate'    => 0,
                'causalRejection'  => 'The client is not valid to finance.'
            ];
        }
        return [
            'validToFinance'   => $financeData['response_status'],
            'guaranteeRate'    => $financeData['guaranteeRate'],
            'causalRejection'  => $financeData['causalRejection']
        ];
    }

    public function returnToStore(FN_CREDITINSCRIPTION $dataClient)
    {
        if (empty($dataClient->status)) {
            $dataClient->status = 'ABORTED';
            $dataClient->causalRejection = 'The financial process has been canceled.';
        }

        $dataClient->update();

        $redirecUrl = $dataClient->redirectionUrl;
        $redirecUrl .= '&orderId=' . $dataClient->orderId;
        $redirecUrl .= '&statusCode=' . $dataClient->status;

        return redirect($redirecUrl);
    }

    function unique_code($limit){
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }
}
