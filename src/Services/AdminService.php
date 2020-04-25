<?php

namespace App\Services;

use App\Entity\Administrador;
use App\Entity\Usuario;

class AdminService{

    public $manager;

    public function __construct($manager)
    {
        $this->manager = $manager;
    }
    public function createAdmin(Usuario $usuario){
        $admin = new Administrador();
        $admin->setId($usuario);
        $admin->setFechaContratacion($usuario->getCreateat());
        $this->manager->persist($admin);
        $this->manager->flush();
        $data = [
            'status' => 'success',
            'code' => '201',
            'msg' => 'Administrador creado',
            'administrador' => $admin
        ];
        return $data;

    }
}