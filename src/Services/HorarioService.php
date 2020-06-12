<?php


namespace App\Services;


use App\Entity\Horario;

class HorarioService
{
    public $manager;

    public function __construct($manager)
{
    $this->manager = $manager;
}
    public function createHorario($json,$jwtAuth){
        $params=json_decode($json);

        $horario_repo=$this->manager->getRepository(Horario::class);
        $horaIni= (!empty($params->horarioInicio)) ? $params->horarioInicio : null;
        $horaFin= (!empty($params->horarioFin)) ? $params->horarioFin : null;
        //¡¡¡¡¡¡¡¡¡¡¡AÑAIDRTOKEN!!!!!!!!!!!!!!!!!!!!!!

        $isset_horario=$horario_repo->findBy(array(
            'horarioInicio'=>$params->horarioInicio,
            'horaFin'=>$params->horarioFin
        ));

        if(count($isset_horario )== 0){
            $horario= new Horario();
            $horario->setHorarioInicio($horaIni);
            $horario->setHoraFin($horaFin);

            $this->manager->persist($horario);
            $this->manager->flush();
            $data=[
                'status' => 'success',
                'code' => 201,
                'msg' => 'horario creado',
                'horario' =>$horario
            ];
        }else{
            $data=[
                'status' => 'success',
                'code' => 200,
                'msg' => 'horario encontrado',
                'horario' => $isset_horario
            ];
        }
        return $data;






    }

}
