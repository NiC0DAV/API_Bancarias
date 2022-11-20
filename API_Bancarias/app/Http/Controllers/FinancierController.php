<?php

namespace App\Http\Controllers;

use App\Http\Requests\MSCusBilCredSimulateEFRequest;
use App\Models\CreditSimulate;
use App\Models\StatusFinanceForEmail;

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
        $request['requestDate'] = date('Y-m-d H:i:s');
        $financeValidation = $this->checkIfIsvalidToFinance($request['email']);
        $request['interestRateType'] = 1;
        $request['interestRate'] = 15.0;
        $request['maximunPaymentTerm'] = 36;
        $creditSimulateValues = array_merge($request->all(), $financeValidation);
        unset($request, $financeValidation);
        $creditSimulate = new CreditSimulate();
        $creditSimulate->fill($creditSimulateValues);
        $creditSimulate->save();
        $response = ['isValidToFinance' => boolval($creditSimulateValues['validToFinance'])];
        if (!$creditSimulateValues['validToFinance'])
            $response['causalRejection'] = $creditSimulateValues['causalRejection'];
        $response['maximumPaymentTerm'] = $creditSimulateValues['maximunPaymentTerm'];
        $response['interestRate'] = $creditSimulateValues['interestRate'];
        $response['interestRateType'] = $creditSimulateValues['interestRateType'];
        $response['guaranteeRate'] =  $creditSimulateValues['guaranteeRate'];
        $response['conditionsUrl'] =  'www.mysandboxfinancer.com/finance-conditions';
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
