<?php


namespace App\Services;


use App\Entity\Dia;
use App\Entity\Horario;
use App\Entity\Medico;
use App\Entity\Usuario;

class DiaService
{
    public $manager;


    public function __construct($manager)
    {
        $this->manager = $manager;
    }
    public function createDia($json){
        $params=json_decode($json);
        $dia_repo=$this->manager->getRepository(Dia::class);
        $dia= (!empty($params->dia)) ? $params->dia : null;
        $idMedico= (!empty($params->idMedico)) ? $params->idMedico : null;
        $idHorario= (!empty($params->idHorario)) ? $params->idHorario : null;
        $usuario_repo=$this->manager->getRepository(Usuario::class);
        $issetUsuario= $usuario_repo->findBy(array(
            'id'=>$params->idMedico
        ));
        $medico_repo= $this->manager->getRepository(Medico::class);
        $issetMedico=$medico_repo->findBy(array(
            'id'=>$issetUsuario[0]
        ));
        $horario_repo=$this->manager->getRepository(Horario::class);
        $issetHorario= $horario_repo->findBy(array(
           'id'=>$idHorario
        ));

        $nuevoDia= new Dia();
        $nuevoDia->setDia($dia);
        $nuevoDia->setMedico($issetMedico[0]);
        $nuevoDia->setHorario($issetHorario[0]);
        $this->manager->persist($nuevoDia);
        $this->manager->flush();
        $data=[
            'status'=>'succes',
            'dia'=>$nuevoDia
        ];
        return $data;
    }


}
