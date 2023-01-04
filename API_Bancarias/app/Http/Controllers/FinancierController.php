<?php

namespace App\Http\Controllers;

use App\Http\Requests\MSCusBilCredSimulateEFRequest;
use App\Models\CreditSimulate;
use App\Models\StatusFinanceForEmail;
use GuzzleHttp\Psr7\Request;

class FinancierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function MSCusBilCredSimulateEF(MSCusBilCredSimulateEFRequest $request)
    {
        $request['requestIP'] = request()->ip();
        $request['requestDate'] = date('Y-m-d\TH:i:s');
        $financeValidation = $this->checkIfIsvalidToFinance($request['client']['email']);
        $request['interestRateType'] = 1;
        $request['interestRate'] = 15.0;
        $request['maximunPaymentTerm'] = 36;
        $creditSimulateValues = array_merge($request->all(), $financeValidation);
        $creditSimulateValues = array_merge($creditSimulateValues, $creditSimulateValues['client']);
        unset($request, $financeValidation, $creditSimulateValues['client']);
        $creditSimulate = new CreditSimulate();
        $creditSimulate->fill($creditSimulateValues);
        $creditSimulate->save();
        $response = ['isValidToFinance' => boolval($creditSimulateValues['validToFinance'])];

        $response['causalRejection'] = !$creditSimulateValues['validToFinance'] ? $creditSimulateValues['causalRejection'] : '';
        $response['financingSimulationInfo']['maximumPaymentTerm'] = $creditSimulateValues['maximunPaymentTerm'];
        $response['financingSimulationInfo']['interestRate'] = $creditSimulateValues['interestRate'];
        $response['financingSimulationInfo']['interestRateType'] = $creditSimulateValues['interestRateType'];
        $response['financingSimulationInfo']['guaranteeRate'] =  $creditSimulateValues['guaranteeRate'];
        $response['conditionsUrl'] =  route('fn-conditions');
        return response()->json($response);
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
}
