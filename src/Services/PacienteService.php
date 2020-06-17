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
    public function putPaciente($json){
        $params=json_decode($json);

        $id=(!empty($params->id)) ? $params->id->id: null;
        $mutua=(!empty($params->mutua)) ? $params->mutua: null;
        $seguridadSocial=(!empty($params->seguridadSocial)) ? $params->seguridadSocial: null;
        $bajaBoolean= !empty($params->baja) ? $params->baja: null;
        $baja=($bajaBoolean)?1:0;
       $userRepo=$this->manager->getRepository(Usuario::class);
       $issetUsuario=$userRepo->findById($id);
       $pacienteRepo=$this->manager->getRepository(Paciente::class);
       $issetPaciente=$pacienteRepo->findById($issetUsuario);
       $issetPaciente[0]->setMutua($mutua);
       $issetPaciente[0]->setSeguridadSocial($seguridadSocial);
       $issetPaciente[0]->setBaja($baja);

        $this->manager->persist($issetPaciente[0]);
        $this->manager->flush();
        return $data=[
            'status'=>'success',
            'code'=>200,
            'paciente'=> $issetPaciente[0]
        ];
    }
}
