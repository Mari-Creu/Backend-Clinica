<?php

namespace App\Controller;

use App\Entity\Especialidad;
use App\Services\EspecialidadService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class EspecialidadController extends AbstractController
{
    //inyecto el servicio
    private $especialidadService;


    /**
     * UsuarioController constructor.
     * @param $usuarioService
     */
    public function __construct(EspecialidadService $especialidadService)
    {
        $this->especialidadService = $especialidadService;
    }


        public function getEspecialidades()
    {
        //comento por ahcer commit en linux
        $espe_repo = $this->getDoctrine()->getManager()->getRepository(Especialidad::class);
        $especialidades = $espe_repo->findAll();

        $data = [
            'especialidades' => $especialidades
        ];
//        return $data;
//
//
//
//        $especialidades= $this->especialidadService->findAll();
        return $this->json($especialidades);
    }
}
