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
        $horaIni= (!empty($params->horaIni)) ? $params->horaIni : null;
        $horaFin= (!empty($params->horaFin)) ? $params->horaFin : null;
        $horario= new Horario();
        $horario->setHorarioInicio($horaIni);
        $horario->setHoraFin($horaFin);
        $this->manager->persist($horario);
        $this->manager->flush();
        var_dump($horario);
        die();
        $data=[
            'horaIni'=>$horaIni,
            'horaFin'=>$horaFin
        ];
        return $data;
    }

}
