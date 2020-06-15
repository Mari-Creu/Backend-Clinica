<?php


namespace App\Services;


use App\Entity\Cita;
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
    public function consultarCitas($json){
        $params=json_decode($json);

        $citas_repo= $this->manager->getRepository(Cita::class);
        $medico_repo= $this->manager->getRepository(Medico::class);

        $dia= (!empty($params->dia)) ? $params->dia : null;
        $medico= (!empty($params->medico)) ? $params->medico : null;
        $issetMedico= $medico_repo->findBy(array(
            'id' => $medico
        ));

//        $fecha= new DateTime( $dia);
//        $fecha2=$fecha->format('d-m-Y');


        $issetCitas= $citas_repo->findBy(array(
            'fechaProgramada'=>$dia,
            'medico' =>$issetMedico[0]
        ));

       $data=[
            'status'=>'success',
            'citas'=> $issetCitas
        ];
       return $data;

    }
    public  function buscarMedicos($json){
        $params=json_decode($json);
        $id=(!empty($params->id)) ? $params->id : null;
        $nombre=(!empty($params->especialidad)) ? $params->especialidad : null;
        $espe_repo = $this->manager->getRepository(Especialidad::class);
        $isset_espe=$espe_repo->findBy(array(
            'id'=>$id
        ));
        $medico_repo= $this->manager->getRepository(Medico::class);
        $issetMedicos=$medico_repo->findBy(array(
            'especialidad'=> $isset_espe[0]
        ));
        return $data=[
            'status'=>'success',
            'medicos'=> $issetMedicos
        ];


    }
}
