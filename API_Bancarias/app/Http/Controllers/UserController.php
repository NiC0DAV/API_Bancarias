<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Helpers\JwtAuth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function createClient(Request $request)
    {
        $clientName = $request->input('cliente', null);
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

    public function MSCusBilCredAuthenticateEF(Request $request)
    {
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
                    'status' => 'Error',
                    'code' => 404,
                    'message' => 'El cliente no se ha podido identificar o los datos ingresados no son validos',
                    'data' => $validate->errors()
                );
            } else {

                $signUp = $jwtAuth->loginClient($paramsArr['clientId'], $paramsArr['clientSecret']);

                if (!empty($signUp) && $signUp != '') {
                    $response = array(
                        'status' => 'Success',
                        'code' => 200,
                        'message' => 'El usuario ha sido identificado exitosamente.',
                        'data' => $signUp
                    );
                } else {
                    $response = array(
                        'status' => 'Error',
                        'code' => 500,
                        'message' => 'Ocurrio un error mientras el usuario iniciaba sesión.',
                        'data' => ''
                    );
                }
            }
        } else {
            $response = array(
                'status' => 'Error',
                'code' => 404,
                'message' => 'El cliente con el que intenta autenticarse no existe en el sistema.',
                'data' => ''
            );
        }

        return response()->json($response, $response['code']);
    }
}
