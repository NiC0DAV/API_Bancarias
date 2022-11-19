<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Helpers\JwtAuth;

class UserController extends Controller
{

    public function createClient(Request $request)
    {
        $clientName = $request->input('cliente');
        $unixTime = strtotime('now');
        $clientId = md5(uniqid($unixTime . $clientName, true));
        $clientSecret = md5(uniqid($unixTime . $clientName, true));

        $client = new User();
        $client->clientName = $clientName;
        $client->clientStatus = 'active';
        $client->clientId = $clientId;
        $client->clientSecret = $clientSecret;
        $client->save();

        $response = array(
            'status' => 'Success',
            'code' => 200,
            'message' => 'El cliente se ha creado correctamente',
            'clientId' => $client->clientId,
            'clientSecret' => $client->clientSecret
        );

        return response()->json($response, $response['code']);
    }

    public function MSCusBilCredAuthenticateEF()
    {
        $jwtAuth = new JwtAuth();
    }
}
