<?php
namespace App\Services;



use App\Entity\Especialidad;

class EspecialidadService
{

    public $manager;

    public function __construct($manager)
    {
        $this->manager = $manager;
    }


    public function findAll()
    {

        $espe_repo = $this->manager->getRepository(Especialidad::class);
        $especialidades = $espe_repo->findAll();

        $data = [
            'especialidades' => $especialidades
        ];
        return $data;
    }
}
