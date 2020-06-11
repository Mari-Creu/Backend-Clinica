<?php

namespace App\Controller;

use App\Services\HorarioService;
use App\Services\JwtAuth;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class HorarioController extends AbstractController
{
    private $horarioService;

    /**
     * HorarioController constructor.
     * @param $horarioService
     */
    public function __construct(HorarioService $horarioService)
    {
        $this->horarioService = $horarioService;
    }


    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/HorarioController.php',
        ]);
    }

    public function createHorario(Request $request, JwtAuth $jwtAuth){
        $json =$request->getContent();
        $params=json_decode($json);
        $data = [
            'status' => 'error',
            'code' => '500',
            'msg' => 'Horario no creado'
        ];
        if($json!=null){
            $data=$this->horarioService->createHorario($json,$jwtAuth);
        }
        return new JsonResponse($data);
    }
}
