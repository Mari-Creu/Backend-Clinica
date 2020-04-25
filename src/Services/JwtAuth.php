<?php

namespace App\Services;

use App\Entity\Usuario;
use Firebase\JWT\JWT;

class JwtAuth
{
    public $manager;
    public $key;

    /**
     * JwtAuth constructor.
     * @param $manager
     */
    public function __construct($manager)
    {
        $this->manager = $manager;
        $this->key = 'ClaveSecretaParaMiTokenDelProyectoClinica';
    }


    public function signup($email, $password, $getToken = null)
    {
        $user = $this->manager->getRepository(Usuario::class)->findOneBy([
            'email' => $email,
            'password' => $password
        ]);
        $signup = (is_object($user)) ? true : false;
        if ($signup) {
            $token = [
                'id' => $user->getId(),
                'nombre' => $user->getNombre(),
                'apellidos' => $user->getApellidos(),
                'email' => $user->getEmail(),
                'rol' => $user->getRol()->getId(),
                'iat' => time(),
                'exp' => time() + (7 * 24 * 60 * 60)
            ];
            $jwt = JWT::encode($token, $this->key, 'HS256');
            if ($getToken) {
                $data = [
                    'status' => 'success',
                    'code' => 200,
                    'msg' => 'Login Correcto',
                    'id' => $user->getId(),
                    'email' => $user->getEmail(),
                    'nombre'=> $user->getNombre(),
                    'password'=>':)',
                    'rol'=> $user->getRol()->getId(),
                    'token' => $jwt
                ];
            } else {
                $jwt_decoded = JWT::decode($jwt, $this->key, ['HS256']);
                $data = $jwt_decoded;
            }
        } else {
            $data = [
                'status' => 'error',
                'msg' => 'Login incorrecto',
                'code' => 401
            ];
        }
        return $data;
    }

    public function checkToken($jwt, $identidad = false)
    {
        try {
            $decoded = JWT::decode($jwt, $this->key, ['HS256']);
        } catch (\UnexpectedValueException $e) {
            $auth = false;
        } catch (\DomainException $e) {
            $auth = false;
        }
        $auth = (isset($decoded) && !empty($decoded) && is_object($decoded) && isset($decoded->id)) ? true : false;

        if ($identidad != false) {
            return $decoded;
        } else {
            return $auth;
        }
    }
}