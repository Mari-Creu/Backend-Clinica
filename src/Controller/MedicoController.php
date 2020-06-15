<?php

namespace App\Controller;

use App\Services\JwtAuth;
use App\Services\MedicoService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MedicoController extends AbstractController
{

    private $medicoService;

    /**
     * MedicoController constructor.
     * @param $medicoService
     */
    public function __construct(MedicoService $medicoService)
    {
        $this->medicoService = $medicoService;
    }

    public function resJson($data)
    {
        $json = $this->get('serializer')->serialize($data, 'json');
        $response = new Response();
        $response->setContent($json);
        $response->headers->set('Content-Type', 'application/json');
        return $response;

    }

    public function update(Request $request, JwtAuth $jwtAuth)
    {
        $json = $request->getContent();

        $data = [
            'status' => 'error',
            'code' => '500',
            'msg' => 'Horario no creado'
        ];

        if (!empty($json)) {
            $data = $this->medicoService->update($json);
        }
        return $this->resJson($data);
    }

    public function consultarCitas(Request $request, JwtAuth $jwtAuth)
    {
        $json = $request->getContent();
        $data = [
            'status' => 'error',
            'code' => '500',
            'msg' => 'Error al consultar las citas'
        ];
        if (!empty($json)) {
            $data = $this->medicoService->consultarCitas($json);
        }
        return $this->resJson($data);
    }

    public function buscarMedicos(Request $request, JwtAuth $jwtAuth)
    {
        $json = $request->getContent();
        $data = [
            'status' => 'error',
            'code' => '500',
            'msg' => 'Error al consultar los médicos por especialidad'
        ];
        if (!empty($json)) {
            $data = $this->medicoService->buscarMedicos($json);
        }
        return $this->resJson($data);
    }
}
