<?php


namespace App\Services;


use App\Entity\Informe;
use App\Entity\Medico;
use App\Entity\Paciente;
use App\Entity\Usuario;

class InformeService
{
    public $manager;

    public function __construct($manager)
    {
        $this->manager = $manager;
    }

    public function createInforme($json)
    {

        $params = json_decode($json);
        $idPaciente = (!empty($params->idPaciente)) ? $params->idPaciente : null;
        $idMedico = (!empty($params->idMedico)) ? $params->idMedico : null;
        $observaciones = (!empty($params->observaciones)) ? $params->observaciones : null;
        $evaluacion = (!empty($params->evaluacion)) ? $params->evaluacion : null;
        $diagnostico = (!empty($params->observaciones)) ? $params->observaciones : null;
        $tratamiento = (!empty($params->observaciones)) ? $params->observaciones : null;
        $userRepo = $this->manager->getRepository(Usuario::class);
        $pacienteRepo = $this->manager->getRepository(Paciente::class);
        $medicoRepo = $this->manager->getRepository(Medico::class);
        $usuarioPaciente = $userRepo->findById($idPaciente);
        $paciente=$pacienteRepo->findById($usuarioPaciente);
        $usuarioMedico=$userRepo->findById($idMedico);
        $medico=$medicoRepo->findById($usuarioMedico);

        $informe= new Informe();

        $informe->setPaciente($paciente[0]);
        $informe->setMedico($medico[0]);
        $informe->setDiagnostico($diagnostico);
        $informe->setEvaluacion($evaluacion);
        $informe->setObservaciones($observaciones);
        $informe->setTratamiento($tratamiento);
        $informe->setFechaInforme(new \DateTime());
        $this->manager->persist($informe);
        $this->manager->flush();

        $data = [
            'status' => 'success',
            'code' => 201,
            'msg' => 'Nuevo informe creado',
            'informe' => $informe
        ];
        return $data;
    }
    public  function getInformes($id){
        $userRepo=$this->manager->getRepository(Usuario::class);
        $issetUsuario=$userRepo->findOneById($id);
        $pacienteRepo=$this->manager->getRepository(Paciente::class);
        $issetPaciente=$pacienteRepo->findOneById($issetUsuario);
        $informeRepo=$this->manager->getRepository(Informe::class);
        $issetInformes=$informeRepo->findBy(array(
            'paciente'=>$issetPaciente
        )) ;
        return $data=[
            'status'=>'success',
            'code'=>200,
            'informes'=>$issetInformes
        ];
    }
}
