<?php

namespace App\Controller;

use App\Services\HabitacionService;
use App\Services\JwtAuth;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HabitacionController extends AbstractController
{
    private $habitacionService;

    /**
     * HabitacionController constructor.
     * @param $habitacionService
     */
    public function __construct(HabitacionService $habitacionService)
    {
        $this->habitacionService = $habitacionService;
    }


    public function resJson($data)
    {
        $json = $this->get('serializer')->serialize($data, 'json');
        $response = new Response();
        $response->setContent($json);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function getHabitacion()
    {
        $data = $this->habitacionService->getHabitacion();
        return $this->resJson($data);
    }
    public function putHabitacion(Request $request, JwtAuth $jwtAuth){
        $json = $request->getContent();

        $data = [
            'status' => 'error',
            'code' => 500,
            'msg' => 'Habitacion no actualizada'
        ];

        if (!empty($json)) {
            $data = $this->habitacionService->putHabitacion($json);
        }
        return $this->resJson($data);
    }
}
