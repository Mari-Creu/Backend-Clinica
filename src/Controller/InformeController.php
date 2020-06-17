<?php

namespace App\Controller;

use App\Services\InformeService;
use App\Services\JwtAuth;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class InformeController extends AbstractController
{
    private $informeService;

    /**
     * InformeController constructor.
     * @param $informeService
     */
    public function __construct(InformeService $informeService)
    {
        $this->informeService = $informeService;
    }


    public function resJson($data)
    {
        $json = $this->get('serializer')->serialize($data, 'json');
        $response = new Response();
        $response->setContent($json);
        $response->headers->set('Content-Type', 'application/json');
        return $response;

    }
    public function createInforme(Request $request, JwtAuth $jwtAuth)
    {
        $json = $request->getContent();
        $data = [
            'status' => 'error',
            'code' => '500',
            'msg' => 'Informe no creado'
        ];

        if ($json != null) {
            $data = $this->informeService->createInforme($json);
        }

        return $this->resJson($data);
    }
    public function getInformes(Request $request, JwtAuth $jwtAuth, $id=null){
        $json = $request->getContent();
        $data = [
            'status' => 'error',
            'code' => '500',
            'msg' => 'Error al buscar los informes'
        ];

        if ($id != null) {
            $data = $this->informeService->getInformes($id);
        }

        return $this->resJson($data);
    }
}
