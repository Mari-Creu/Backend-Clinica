<?php

namespace App\Controller;

use App\Services\DiaService;
use App\Services\JwtAuth;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DiaController extends AbstractController
{
    private $diaService;

    /**
     * DiaController constructor.
     * @param $diaService
     */
    public function __construct(DiaService $diaService)
    {
        $this->diaService = $diaService;
    }


    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/DiaController.php',
        ]);
    }

    public function resJson($data)
    {
        $json = $this->get('serializer')->serialize($data, 'json');
        $response = new Response();
        $response->setContent($json);
        $response->headers->set('Content-Type', 'application/json');
        return $response;

    }
    public function createDia(Request $request, JwtAuth $jwtAuth){
        $json=$request->getContent();
        $data = [
            'status' => 'error',
            'code' => '500',
            'msg' => 'Dia no creado'
        ];
        if(!empty($json)){
            $data=        $this->diaService->createDia($json);

        }
        return $this->resJson($data);
    }
}
