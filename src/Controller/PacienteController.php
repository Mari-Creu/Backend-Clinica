<?php

namespace App\Controller;

use App\Services\JwtAuth;
use App\Services\PacienteService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PacienteController extends AbstractController
{
    private $pacienteService;

    /**
     * PacienteController constructor.
     * @param $pacienteService
     */
    public function __construct(PacienteService $pacienteService)
    {
        $this->pacienteService = $pacienteService;
    }

    public function resJson($data)
    {
        $json = $this->get('serializer')->serialize($data, 'json');
        $response = new Response();
        $response->setContent($json);
        $response->headers->set('Content-Type', 'application/json');
        return $response;

    }

    public function findPaciente(Request $request, JwtAuth $jwtAuth,$id=null)
    {
        $json = $request->getContent();

        $data = [
            'status' => 'error',
            'code' => '500',
            'msg' => 'Paciente no encontrado'
        ];

        if (!empty($id)) {
            $data = $this->pacienteService->findPaciente($id);
        }
        return $this->resJson($data);
    }
    public function putPaciente(Request $request, JwtAuth $jwtAuth){
        $json = $request->getContent();

        $data = [
            'status' => 'error',
            'code' => 500,
            'msg' => 'Paciente no actualizado'
        ];

        if (!empty($json)) {
            $data = $this->pacienteService->putPaciente($json);
        }
        return $this->resJson($data);
    }
}
