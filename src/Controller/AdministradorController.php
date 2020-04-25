<?php

namespace App\Controller;

use App\Services\AdminService;
use App\Services\JwtAuth;
use App\Services\UsuarioService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AdministradorController extends AbstractController
{
    private $usuarioService;
    private $adminService;

    /**
     * UsuarioController constructor.
     * @param $usuarioService
     */
    public function __construct(UsuarioService $usuarioService, AdminService $adminService)
    {
        $this->usuarioService = $usuarioService;
        $this->adminService= $adminService;
    }


    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/AdministradorController.php',
        ]);
    }

    public function createAdmin(Request $request, JwtAuth $jwtAuth)
    {

        $token = $request->headers->get('Authorization', null);
        $authCheck = $jwtAuth->checkToken($token);
        $identidadUsuario = $jwtAuth->checkToken($token, true);
        if($identidadUsuario->rol==2 && $authCheck){
            $json = $request->getContent();
            if (!empty($json)) {
                $data = $this->usuarioService->createUsuario($json, 2);
                if($data['code'] == 201){
                    $data=$this->adminService->createAdmin($data['usuario']);
                }else{
                    $data = [
                        'status' => 'error',
                        'code' => '500',
                        'msg' => 'No se ha creado el nuevo usuario administrador'
                    ];
                }
            }
        }else{
            $data = [
                'status' => 'error',
                'code' => '401',
                'msg' => 'No tiene permisos de administrador'
            ];
        }
        return $this->json($data);
    }
}
