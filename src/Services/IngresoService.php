<?php


namespace App\Services;


use App\Entity\Habitacion;
use App\Entity\Ingreso;
use App\Entity\Paciente;
use App\Entity\Usuario;

class IngresoService
{
    public $manager;

    public function __construct($manager)
    {
        $this->manager = $manager;
    }
    public function createIngreso($json){

        $params=json_decode($json);
        $habitacionRepo=$this->manager->getRepository(Habitacion::class);
    $userRepo=$this->manager->getRepository(Usuario::class);
    $pacienteRepo=$this->manager->getRepository(Paciente::class);

        $idPaciente= (!empty($params->idPaciente)) ? $params->idPaciente: null;
        $idHabitacion= (!empty($params->idHabitacion)) ? $params->idHabitacion : null;
        $fechaSalida= (!empty($params->fechaSalida)) ? $params->fechaSalida : null;

        $issetHabitacion=$habitacionRepo->findOneById($idHabitacion);
        $issetUsuario=$userRepo->findOneById($idPaciente);
        $issetPaciente=$pacienteRepo->findOneById($issetUsuario);

        $ingreso= new Ingreso();
        $ingreso->setPaciente($issetPaciente);
        if($fechaSalida==null){
            $ingreso->setFechaIngreso(new \DateTime());
        }else{
            $ingreso->setFechaSalida($fechaSalida);
        }
        $ingreso->setHabitacion($issetHabitacion);
    $this->manager->persist($ingreso);
    $this->manager->flush();
    $data=[
        'status'=>'success',
        'code'=>20,
        'ingreso'=>$ingreso
    ];

    return $data;
    }
    public function findIngreso($id){

        $ingresoRepo=$this->manager->getRepository(Ingreso::class);
        $userRepo=$this->manager->getRepository(Usuario::class);
        $pacienteRepo=$this->manager->getRepository(Paciente::class);
        $issetUsuario=$userRepo->findOneById($id);
        $issetPaciente=$pacienteRepo->findOneById($issetUsuario);

        $issetIngreso=$ingresoRepo->findBy(array(
            'paciente'=>$issetPaciente,
            'fechaSalida'=>null
        ));
        if(count($issetIngreso)>0){
            $data=[
                'status'=>'success',
                'code'=>200,
                'ingreso'=>$issetIngreso[0]
            ];
        }else{
            $data=[
                'status'=>'not found',
                'code'=>404,
                'ingreso'=> 'El paciente no se encuentra ingresado en la clínica'
            ];
        }

        return $data;
    }
    public function putIngreso($json){
        $params=json_decode($json);
        $id=(!empty($params->id)) ? $params->id: null;
        $ingresoRepo=$this->manager->getRepository(Ingreso::class);
        $issetIngreso=$ingresoRepo->findOneById($id);
        $issetIngreso->setFechaSalida(new \DateTime());
        $this->manager->persist($issetIngreso);
        $this->manager->flush();
        $data=[
            'status'=>'success',
            'code'=>200,
            'ingreso'=>$issetIngreso
        ];
        return $data;

    }
}
