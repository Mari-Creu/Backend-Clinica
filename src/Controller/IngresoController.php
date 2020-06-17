<?php

namespace App\Controller;

use App\Services\IngresoService;
use App\Services\JwtAuth;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IngresoController extends AbstractController
{
    private $ingresoService;

    /**
     * IngresoController constructor.
     * @param $ingresoService
     */
    public function __construct(IngresoService $ingresoService)
    {
        $this->ingresoService = $ingresoService;
    }
    public function resJson($data)
    {
        $json = $this->get('serializer')->serialize($data, 'json');
        $response = new Response();
        $response->setContent($json);
        $response->headers->set('Content-Type', 'application/json');
        return $response;

    }

    public function createIngreso(Request $request, JwtAuth $jwtAuth)
    {
        $json =$request->getContent();

        $data = [
            'status' => 'error',
            'code' => '500',
            'msg' => 'Ingreso no creado'
        ];
        if($json!=null){
            $data=$this->ingresoService->createIngreso($json);
        }
        return $this->resJson($data);
    }
    public function findIngreso(Request $request, JwtAuth $jwtAuth, $id=null){

      $json =$request->getContent();

        $data = [
            'status' => 'error',
            'code' => '500',
            'msg' => 'Ingreso no encontrado'
        ];

        if($id!=null){
            $data=$this->ingresoService->findIngreso($id);
        }
        return $this->resJson($data);
    }
    public  function putIngreso(Request $request, JwtAuth $jwtAuth){
        $json = $request->getContent();

        $data = [
            'status' => 'error',
            'code' => 500,
            'msg' => 'Ingreso no actualizado'
        ];

        if (!empty($json)) {
            $data = $this->ingresoService->putIngreso($json);
        }
        return $this->resJson($data);
    }
}
