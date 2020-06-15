<?php

namespace App\Controller;


use App\Services\CitaService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CitaController extends AbstractController
{
    private $citaService;

    /**
     * CitaController constructor.
     * @param $citaService
     */
    public function __construct(CitaService $citaService)
    {
        $this->citaService = $citaService;
    }


    public function resJson($data)
    {
        $json = $this->get('serializer')->serialize($data, 'json');
        $response = new Response();
        $response->setContent($json);
        $response->headers->set('Content-Type', 'application/json');
        return $response;

    }
    /**
     * @Route("/cita", name="cita")
     */
    public function create(Request $request)
    {
        $json =$request->getContent();

        $data = [
            'status' => 'error',
            'code' => '500',
            'msg' => 'Error al crear la cita'
        ];
        if(!empty($json)){
            $data= $this->citaService->createCita($json);
        }
        return $this->resJson($data);
    }
}
