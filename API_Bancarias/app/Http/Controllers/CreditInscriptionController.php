<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreditInscriptionController extends Controller
{

    public function MSCusBilCredInscriptionEF(Request $request)
    {
        $payload = $request->getContent();

        $payloadParse = json_decode($payload);

        // response()->json($payload, 200)
        return $payloadParse;
    }
}
