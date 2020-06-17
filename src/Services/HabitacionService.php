<?php


namespace App\Services;


use App\Entity\Habitacion;

class HabitacionService
{
    public $manager;

    public function __construct($manager)
    {
        $this->manager = $manager;
    }

    public function getHabitacion(){

        $habRepo=$this->manager->getRepository(Habitacion::class);
        $issetHab=$habRepo->findBy(array(
            'ocupada'=>false
        ));
        if(count($issetHab)>0){
            $issetHab[0]->setOcupada(true);
            $this->manager->persist($issetHab[0]);
            $this->manager->flush();
            $data=[
                'status'=>'succes',
                'code'=>200,
                'habitacion'=>$issetHab[0]
            ];
        }else{
            $data=[
                'status'=>'succes',
                'code'=>404,
                'habitacion'=>'No hay habitaciones disponibles en la clínica. Habrá que derivar al paciente'
            ];
        }

        return $data;

    }
    public function putHabitacion($json){
        $params=json_decode($json);

        $id=(!empty($params->id)) ? $params->id: null;
        $habRepo=$this->manager->getRepository(Habitacion::class);
        $issetHabitacion=$habRepo->findOneById($id);
        $issetHabitacion->setOcupada(false);

        $this->manager->persist($issetHabitacion);
        $this->manager->flush();
        return $data=[
            'status'=>'success',
            'code'=>200,
            'habitacion'=> $issetHabitacion
        ];
    }

}
