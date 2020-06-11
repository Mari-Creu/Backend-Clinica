<?php

namespace App\Services;


use App\Entity\Administrador;
use App\Entity\Medico;
use App\Entity\Paciente;
use App\Entity\Rol;
use App\Entity\Usuario;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Validation;

class UsuarioService
{

    public $manager;

    public function __construct($manager)
    {
        $this->manager = $manager;
    }

    public function createUsuario($json, $jwtAuth, $rol = 1)
    {
        $params = json_decode($json);
        $user_repo = $this->manager->getRepository(Usuario::class);

        $nombre = (!empty($params->nombre)) ? $params->nombre : null;
        $password = (!empty($params->password)) ? $params->password : null;
        $email = (!empty($params->email)) ? $params->email : null;
        $apellidos = (!empty($params->apellidos)) ? $params->apellidos : null;
        $rol = (!empty($params->rol)) ? $params->rol : $rol;
        $validator = Validation::createValidator();
        $validate_email = $validator->validate($email, [
            new Email()
        ]);
        $isset_user = $user_repo->findBy(array(
            'email' => $params->email
        ));


        if (!empty($email) && count($validate_email) == 0 && !empty($password)) {
            $rol_repo = $this->manager->getRepository(Rol::class);
            $idrol=null;
            switch ($rol) {
                case 1:
                    $idrol = $rol_repo->find(1);
                    break;
                case 2:
                    $idrol = $rol_repo->find(2);
                    break;
                case 3:
                    $idrol = $rol_repo->find(3);
                    break;
            }
        }
        $usuario = new Usuario();
        $usuario->setNombre($nombre);
        $usuario->setApellidos($apellidos);
        $usuario->setEmail($email);
        $pwd = hash('sha256', $password);
        $usuario->setPassword($pwd);
        $usuario->setRol($idrol);
        $usuario->setCreateat(new \DateTime('now'));

        if (count($isset_user) == 0) {
            $this->manager->persist($usuario);
            $this->manager->flush();
            $token = $jwtAuth->signup($email, $pwd, true);
            $tipoUsuario= $this->createRolUsuario($rol,$email);
            $data = [
                'status' => 'success',
                'code' => 201,
                'msg' => 'Usuario creado',
                'token' => $token,
                'usuario' => $usuario
            ];


        } else {
            $data = [
                'status' => 'error',
                'code' => 400,
                'msg' => 'Usuario ya existe'
            ];
        }
        return $data;
    }

    public function createRolUsuario(int $rol,String $email)
    {
        $user=null;
        $user_repo=$this->manager->getRepository(Usuario::class);
        $usuario = $user_repo->findOneBy([
            'email' => $email
        ]);
        switch ($rol){
            case 1:
                $user = new Paciente();
                $user->setId($usuario);
//                $paciente_repo=$this->manager->getRepository(Paciente::class);
                $this->manager->persist($user);
                $this->manager->flush();

                break;
            case 2:
                $user= new Administrador();
                $user->setId($usuario);
                $this->manager->persist($user);
                $this->manager->flush();
                break;
            case 3:
                $user= new Medico();
                $user->setId($usuario);
                $this->manager->persist($user);
                $this->manager->flush();
                break;
        }
        return $user;
    }

    public function updateUsuario($idUsuario, $json)
    {
        $user_repo = $this->manager->getRepository(Usuario::class);
        $usuario = $user_repo->findOneBy([
            'id' => $idUsuario->id
        ]);
        $params = json_decode($json);
        if (!empty($json)) {
            $nombre = (!empty($params->nombre)) ? $params->nombre : null;
            $apellidos = (!empty($params->apellidos)) ? $params->apellidos : null;
            if ($usuario->getEmail() == $params->email) {
                $usuario->setNombre($nombre);
                $usuario->setApellidos($apellidos);
                $this->manager->persist($usuario);
                $this->manager->flush();
                $data = [
                    'status' => 'succes',
                    'msg' => 'Usuario actualizado',
                    'code' => '200',
                    'usuario' => $usuario
                ];
            } else {
                $data = [
                    'status' => 'error',
                    'msg' => 'Usuario no actualizado, error en los nuevos datos',
                    'code' => '400',
                ];
            }
            return $data;
        }
        return null; //añadido por probar error wamp
    }

    public function findById($json)
    {
        $user_repo = $this->manager->getRepository(Usuario::class);
        $usuario = $user_repo->findOneBy([
            'id' => $json
        ]);
        $usuario->setPassword(':)');
        $usuario->setRol(null);
        $data = [
            'usuario' => $usuario
        ];
        return $data;

    }

    public function deleteById($id)
    {

        $user_repo = $this->manager->getRepository(Usuario::class);
        $admin_repo = $this->manager->getRepository(Administrador::class);
        $usuario = $user_repo->findOneBy([
            'id' => $id
        ]);
        $data = [
            'status' => 'error',
            'msg' => 'Error al borrar!',
            'code' => 400
        ];

        if ($usuario && is_object($usuario)) {

            if ($usuario->getRol()->getId() == 1) {
                $paciente_repo = $this->manager->getRepository(Paciente::class);
                $paciente = $paciente_repo->findOneBy([
                    'id' => $usuario
                ]);
                $this->manager->remove($paciente);
                $this->manager->flush();
                $this->manager->remove($usuario);
                $this->manager->flush();
                $data = [
                    'status' => 'success',
                    'msg' => 'usuario borrado!',
                    'code' => 200,
                    'usuario' => $usuario
                ];
                return $data;
            }

        }
    }

    public function updateFoto($id, $fileName)
    {
        $user_repo = $this->manager->getRepository(Usuario::class);
        $usuario = $user_repo->findOneBy([
            'id' => $id
        ]);
        if (!empty($usuario)) {
            if ($usuario->getImagen() != null) {
                unlink('./uploads/' . $usuario->getImagen());
            }
            $usuario->setImagen($fileName);
            $this->manager->persist($usuario);
            $this->manager->flush();
            $data = [
                'status' => 'success',
                'msg' => 'Imagen actualizada!',
                'code' => 200,
                'usuario' => $usuario
            ];
        } else {
            $data = [
                'status' => 'error',
                'msg' => 'Error al actualizar la imagen!',
                'code' => 400
            ];
        }

        return $data;

    }
}
