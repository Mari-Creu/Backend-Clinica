<?php

namespace App\Services;

use App\Entity\Cita;
use App\Entity\Medico;
use App\Entity\Paciente;
use App\Entity\Usuario;
use DateTime;
use Cassandra\Date;

class CitaService{

    public $manager;

    public function __construct($manager)
    {
        $this->manager = $manager;
    }
    public function createCita($json){
        $params=json_decode($json);
        $idMedico= (!empty($params->idMedico)) ? $params->idMedico : null;
        $idPaciente= (!empty($params->idPaciente)) ? $params->idPaciente : null;
        $fechaProgramada= (!empty($params->fechaProgramada)) ? $params->fechaProgramada : null;
        $horaCita= (!empty($params->horaCita)) ? $params->horaCita : null;
        $urgencia= (!empty($params->urgencia)) ? $params->urgencia : null;

        $usuario_repo=$this->manager->getRepository(Usuario::class);
        $medico_repo= $this->manager->getRepository(Medico::class);
        $paciente_repo= $this->manager->getRepository(Paciente::class);
        $issetUsuarioM=$usuario_repo->findBy(array(
            'id'=> $idMedico
        ));
        $issetMedico=$medico_repo->findBy(array(
            'id'=>$issetUsuarioM[0]
        ));
        $issetUsuarioP=$usuario_repo->findBy(array(
            'id'=>$idPaciente
        ));
        $issetPaciente=$paciente_repo->findBy(array(
            'id'=>$issetUsuarioP[0]
        ));

        $cita = new Cita();
        $cita->setMedico($issetMedico[0]);
//        $fecha= new DateTime( $fechaProgramada);
//        $fecha2=$fecha->format('d-m-Y');

//        $fecha2=\date_create($fecha,'d-M-Y');

        $cita->setFechaProgramada($fechaProgramada);

        $cita->setFechaRegistro(new \DateTime('now'));

        $cita->setPaciente($issetPaciente[0]);

        $cita->setUrgencia($urgencia);

        $cita->setHoraCita($horaCita);

        $this->manager->persist($cita);
        $this->manager->flush();

        $data = [
            'status' => 'success',
            'code' => '201',
            'msg' => 'Nueva cita creado',
            'cita' => $cita
        ];
        return $data;

    }
}
