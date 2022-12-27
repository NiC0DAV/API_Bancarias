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
                'status' => 'Invalid Client',
                'code' => 404,
                'message' => 'The client could not be registered.',
                'data' => $validate->errors()
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
                'message' => 'The client has been created successfully',
                'clientId' => $client->clientId,
                'clientSecret' => $client->clientSecret
            );
        }

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
                    'status' => 'Invalid Client',
                    'message' => 'The client could not be identified or the entered data is invalid',
                    'data' => $validate->errors()
                );
                $status = 404;
            } else {
                $signUp = $jwtAuth->loginClient($paramsArr['clientId'], $paramsArr['clientSecret']);
                if (!empty($signUp) && $signUp != '') {
                    $response = array(
                        'accessToken' => $signUp,
                        'expirationTime' => 5,
                    );
                    $status = 200;
                } else {
                    $response = array(
                        'errorCode' => '404',
                        'errorDescription' => 'There was an error while the authentication was in progress.',
                        'data' => ''
                    );
                    $status = 404;
                }
            }
        } else {
            $response = array(
                'errorCode' => '404',
                'message' => 'The client does not exist on the database.',
                'data' => ''
            );
            $status = 404;
        }

        return response()->json($response, $status);
    }
}