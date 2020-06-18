<?php

namespace App\Controller;

use App\Services\InformeService;
use App\Services\JwtAuth;
use Knp\Component\Pager\PaginatorInterface;
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
    public function  getInformesPorMedico(Request $request, JwtAuth $jwtAuth, $id=null){
        $json = $request->getContent();
        $data = [
            'status' => 'error',
            'code' => '500',
            'msg' => 'Error al buscar los informes por médico'
        ];
        if ($id != null) {
            $data = $this->informeService->getInformesPorMedico($id);
        }
        return $this->resJson($data);
    }
    public  function buscarInformes(Request $request, JwtAuth $jwtAuth, PaginatorInterface $paginator){
        $data = [
            'status' => 'error',
            'msg' => 'No se pueden listar los informes',
            'code' => 404,
        ];
        $token = $request->headers->get('Authorization', null);
        $auth_token = $jwtAuth->checkToken($token);
//        $rol=$request->get('rol',null);
        $json = $request->getContent();
        $params = json_decode($json);



        if ($auth_token) {
            $em = $this->getDoctrine()->getManager();
            $id = (!empty($params->idMedico)) ? $params->idMedico : null;
            $termino = (!empty($params->term)) ? $params->term : null;

            $dql = "SELECT i FROM App\Entity\Informe as i  where i.medico=$id 
            and i.paciente in
            ( Select u.id from App\Entity\Usuario as u where u.nombre like '$termino') ";
            $query = $em->createQuery($dql);

            $page = $request->query->getInt('page', 1);
            $items_per_page = 10;
            $pagination = $paginator->paginate($query, $page, $items_per_page);

            $total = $pagination->getTotalItemCount();


            $data = [
                'status' => 'success',
                'msg' => 'Listado de usuarios paginado',
                'code' => 200,
                'total_items_count' => $total,
                'page_actual' => $page,
                'items_per_page' => $items_per_page,
                'total_pages' => ceil($total / $items_per_page),
                'informes' => $pagination
            ];
            return $this->resJson($data);
        }
    }
}
