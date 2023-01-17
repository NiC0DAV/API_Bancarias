<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use App\Models\User;
use DomainException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\Key;
use InvalidArgumentException;
use UnexpectedValueException;

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
                'exp' => time() + (60 * 10) //10 min
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

    public function checkToken($jwt, $getIdentity = false)
    {
        $response = false;

        try {
            if (strpos($jwt, 'Bearer') !== false) {
                $jwt = str_replace(array('"'), '', $jwt);
                $jwt = ltrim($jwt, 'Bearer');
                $jwt = ltrim($jwt, ' ');
            } else {
                $jwt = str_replace(array('"'), '', $jwt);
            }

            $decoded = JWT::decode($jwt, new key($this->secretKey, 'HS256'));
        } catch (DomainException $e) {
            $response = 'Unsupported algorithm or bad key was specified';
        } catch (ExpiredException $e) {
            $response = 'Expired token';
        } catch (InvalidArgumentException $e) {
            $response = 'Key may not be empty';
        } catch (UnexpectedValueException $e) {
            $response = 'Wrong number of segments';
        }

        if (!empty($decoded) && is_object($decoded) && isset($decoded->clientId) && isset($decoded->clientSecret)) {
            $response = true;
        }

        if ($getIdentity) {
            return $decoded;
        }

        return $response;
    }
}
