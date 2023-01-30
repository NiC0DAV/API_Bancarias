<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Helpers\JwtAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth:api', ['except' => ['MSCusBilCredAuthenticateEF', 'createClient']]);
    }

    public function createClient(Request $request)
    {
        $clientName = $request->input('cliente', null);
        $financialCode = $request->input('codigoFinanciero', null);
        $unixTime = strtotime('now');
        $clientId = md5(uniqid($unixTime . $clientName, true));
        $clientSecret = md5(uniqid($unixTime . $clientName, true));

        $paramsArr = ['clientId' => $clientId, 'clientSecret' => $clientSecret, 'financialCode' => $financialCode, 'clientName' => $clientName];

        $validate = Validator::make($paramsArr, [
            'clientId' => 'required|unique:users',
            'clientSecret' => 'required|unique:users',
            'financialCode' => 'required|unique:users',
            'clientName' => 'required'
        ]);

        if ($validate->fails()) {
            $response = array(
                'code' => 404,
                'errorDescription' => 'El cliente no pudo ser registrado, por favor intentelo nuevamente.',
                'errors' => $validate->errors()
            );
        } else {
            $client = new User();
            $client->clientName = $clientName;
            $client->clientStatus = 'active';
            $client->clientId = $clientId;
            $client->clientSecret = $clientSecret;
            $client->financialCode = $financialCode;
            $client->save();

            $response = array(
                'status' => 'Success',
                'code' => 200,
                'message' => 'El cliente ha sido creado exitosamente',
                'clientId' => $client->clientId,
                'clientSecret' => $client->clientSecret
            );
        }

        return response()->json($response, $response['code']);
    }

    public function MSCusBilCredAuthenticateEF(Request $request)
    {
        $request->validate([
            'clientId' => 'required',
            'clientSecret' => 'required',
        ]);
        $jwtAuth = new JwtAuth();
        $clientId = $request->input('clientId', null);
        $clientSecret = $request->input('clientSecret', null);
        $paramsArr = ['clientId' => $clientId, 'clientSecret' => $clientSecret];

        $checkClient = User::where([
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
        ])->first();

        if ($checkClient != null && !empty($checkClient)) {

            $validate = Validator::make($paramsArr, [
                'clientId' => 'required',
                'clientSecret' => 'required'
            ]);

            if ($validate->fails()) {
                $response = array(
                    'errorCode' => '400',
                    'errorDescription' => 'No fue posible identificar al cliente o los datos ingresados no son válidos',
                    'traceId' => 'L101'
                );
                $status = $response['errorCode'];
            } else {
                $signUp = $jwtAuth->loginClient($paramsArr['clientId'], $paramsArr['clientSecret']);
                if (!empty($signUp) && $signUp != '') {
                    $response = array(
                        'accessToken' => $signUp,
                        'expirationTime' => 10,
                    );
                    $status = 200;
                } else {
                    $response = array(
                        'errorCode' => '500',
                        'errorDescription' => 'Hubo un error mientras la autenticación estaba en curso.',
                        'traceId' => 'L501'
                    );
                    $status = $response['errorCode'];
                }
            }
        } else {
            $response = array(
                'errorCode' => '400',
                'errorDescription' => 'No fue posible identificar al cliente o los datos ingresados no son válidos',
                'traceId' => 'L303'
            );
            $status = $response['errorCode'];
        }

        return response()->json($response, $status);
    }
}
