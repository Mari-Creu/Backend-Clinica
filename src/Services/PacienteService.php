<?php


namespace App\Services;


use App\Entity\Paciente;
use App\Entity\Usuario;

class PacienteService
{
    public $manager;


    public function __construct($manager)
    {
        $this->manager = $manager;
    }

    public function findPaciente($id){
        $usuarios_repo=$this->manager->getRepository(Usuario::class);
        $issetUsuario=$usuarios_repo->findById($id);
        $paciente_repo=$this->manager->getRepository(Paciente::class);
        $issetPaciente=$paciente_repo->findById($issetUsuario);
       return $data=[
           'status'=>'success',
           'code'=>200,
           'paciente'=>$issetPaciente
       ];
    }
}
