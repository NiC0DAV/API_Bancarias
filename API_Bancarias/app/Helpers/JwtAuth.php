<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use DomainException;
use Firebase\JWT\Key;
use Symfony\Component\HttpFoundation\File\Exception\UnexpectedTypeException;

class JwtAuth
{
    private $secretKey = 'infodec2022';

    public function loginClient($clientId, $clientSecret, $getToken = null)
    {
        $login = false;

        $client = User::where([
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
        ])->first();

        if (is_object($client)) {
            $login = true;
        }

        if ($login) {
            $data = array(
                'clientName' => $client->clientName,
                'clientId' => $client->clientId,
                'clientSecret' => $client->clientSecret,
                'iat' => time(),
                'exp' => time() + (60 * 5) //5 min
            );

            $jwtToken = JWT::encode($data, $this->secretKey, 'HS256');

            $decodeJwt = JWT::decode($jwtToken, new key($this->secretKey, 'HS256'));

            if (is_null($getToken)) {
                $data = $jwtToken;
            } else {
                $data = $decodeJwt;
            }
        } else {
            $data = array(
                'status' => 'Error',
                'message' => 'Intento de autenticación incorrecto'
            );
        }

        return $data;
    }

    public function checkToken($jwt, $getIdentity = true)
    {
        $auth = false;

        try {
            $jwt = str_replace('"', '', $jwt);
            $decoded = JWT::decode($jwt, new key($this->secretKey, 'HS256'));
        } catch (UnexpectedTypeException $e) {
            $auth = false;
        } catch (DomainException $e) {
            $auth = false;
        }

        if (!empty($decoded) && is_object($decoded) && isset($decoded->clientId) && isset($decoded->clientSecret)) {
            $auth = true;
        } else {
            $auth = false;
        }

        if ($getIdentity) {
            return $decoded;
        }

        return $auth;
    }
}
