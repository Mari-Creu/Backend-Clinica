<?php


namespace App\Services;


use App\Entity\Especialidad;
use App\Entity\Medico;
use App\Entity\Usuario;
use DateTime;

class MedicoService
{
    public $manager;


    public function __construct($manager)
    {
        $this->manager = $manager;
    }
     public function update($json){
        $params=json_decode($json);
        $medico_repo= $this->manager->getRepository(Medico::class);
        $usuario_repo=$this->manager->getRepository(Usuario::class);
        $especialidad_repo=$this->manager->getRepository(Especialidad::class);
        $issetEspecialidad=$especialidad_repo->findBy(array(
            'id'=>$params->especialidad
        ));
        $issetUsuario= $usuario_repo->findBy(array(
           'id'=>$params->id->id
        ));

        $issetMedico= $medico_repo->findBy(array(
           'id' =>$issetUsuario
        ));
        $fechaContratacion= (!empty($params->fechaContratacion)) ? $params->fechaContratacion : null;
        $fechaFinContrato= (!empty($params->fechaFinContrato)) ? $params->fechaFinContrato : null;
        $issetMedico[0]->setEspecialidad($issetEspecialidad[0]);


        $issetMedico[0]->setFechaContratacion(new DateTime($fechaContratacion));
        $issetMedico[0]->setFechaFinContrato(new DateTime($fechaFinContrato));
        $this->manager->persist($issetMedico[0]);
        $this->manager->flush();
        return $data=[
            'status'=>'success',
            'medico'=> $issetMedico[0]
        ];
     }

}
