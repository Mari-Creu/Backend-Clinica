<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Services\JwtAuth;
use App\Services\UsuarioService;
use Knp\Component\Pager\PaginatorInterface;
use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Validation;

class UsuarioController extends AbstractController
{
    //inyecto el servicio
    private $usuarioService;


    /**
     * UsuarioController constructor.
     * @param $usuarioService
     */
    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function resJson($data){
          $json=$this->get('serializer')->serialize($data,'json');
          $response = new Response();
          $response->setContent($json);
          $response->headers->set('Content-Type','application/json');
          return $response;

    }


    public function index()
    {

        $user_repo = $this->getDoctrine()->getRepository(Usuario::class);
        $users = $user_repo->findAll();
        $user = $user_repo->find(4);

        return $this->resJson($users);

    }

    public function create(Request $request, JwtAuth $jwtAuth)
    {
        $json = $request->getContent();
        $params=json_decode($json);

        $data = [
            'status' => 'error',
            'code' => '500',
            'msg' => 'Usuario no creado'
        ];

        if ($json != null) {
            $data = $this->usuarioService->createUsuario($json, $jwtAuth, 1);
        }
        return new JsonResponse($data);
    }

    public function login(Request $request, JwtAuth $jwtAuth)
    {
        $json = $request->getContent();
        $params = json_decode($json);
        $data = [
            'status' => 'error',
            'code' => 401,
            'msg' => 'Credenciales Incorrectas'
        ];
        if ($json != null) {
            $password = (!empty($params->password)) ? $params->password : null;
            $email = (!empty($params->email)) ? $params->email : null;
            $getToken = (!empty($params->nombre)) ? $params->nombre : null;

            $validator = Validation::createValidator();
            $validateEmail = $validator->validate($email, [
                new Email()
            ]);
            if (!empty($email) && count($validateEmail) == 0 && !empty($password)) {
                $pwd = hash('sha256', $password);
//                $jwtAuth->signup($email, $pwd);

                if ($getToken) {
                    $signup = $jwtAuth->signup($email, $pwd, $getToken);
                } else {
                    $signup = $jwtAuth->signup($email, $pwd);

                }
                return new JsonResponse($signup);
            }
        }


        return $this->json($data);
    }


    public function update(Request $request, JwtAuth $jwtAuth)
    {
        $token = $request->headers->get('Authorization', null);
        $auth_token = $jwtAuth->checkToken($token);
        $data = [
            'status' => 'error',
            'msg' => 'Usuario no actualizado',
            'code' => '400',
        ];
        if ($auth_token) {
            $idUsuario = $jwtAuth->checkToken($token, true);
            $json = $request->getContent();
            $data = $this->usuarioService->updateUsuario($idUsuario, $json);
        }
        return $this->json($data);
    }

    public function findAll(Request $request, JwtAuth $jwtAuth, PaginatorInterface $paginator)
    {
        $data = [
            'status' => 'error',
            'msg' => 'No se pueden listar los usuarios',
            'code' => 404,
        ];
        $token = $request->headers->get('Authorization', null);
        $auth_token = $jwtAuth->checkToken($token);
        $rol=$request->get('rol',null);

        if ($auth_token) {
            $em = $this->getDoctrine()->getManager();

            $dql = "SELECT u FROM App\Entity\Usuario u WHERE u.rol=".$rol;
            $query = $em->createQuery($dql);

            $page = $request->query->getInt('page', 1);

            $items_per_page = 5;
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
                'usuarios' => $pagination
            ];
        }


        return $this->json($data);
    }

    public function findById(Request $request)
    {
        $data = [
            'status' => 'error',
            'msg' => 'No se encuentra el usuario',
            'code' => 404,
        ];
        //FALTA AÑADIR TOKEN
        $json = $request->getContent();
        $data = $this->usuarioService->findById($json);
        return $this->json($data);
    }

    public function upload(Request $request)
    {
        $file = $request->files->get('imagen');
        $id = $request->get('id');
        if ($id == null) {
            $data = [
                'status' => 'error',
                'msg' => 'Error en el usuario al cambiar la fotografía de perfil',
                'code' => 402,
            ];
        } else {
            $data = [
                'status' => 'error',
                'msg' => 'No se ha recibido la imagen',
                'code' => 404,
            ];
        }
        if ($file != null) {
            $ext = $file->guessExtension();
            $fileName = $id . '-' . time() . "." . $ext;
            //Compruebo extensiones de imagenes
            $extensiones = array('png', 'jpg', 'gif', 'jpeg');
            if (!in_array($ext, $extensiones)) {
                $data = [
                    'status' => 'error',
                    'msg' => 'La Extensión del archivo seleccionada  no es válida',
                    'code' => 400,
                ];
            }
            try {
                $file->move("uploads", $fileName);
                $data = $this->usuarioService->updateFoto($id, $fileName);

            } catch (Exception $exception) {
                $data = [
                    'status' => 'error',
                    'msg' => 'Error al mover el archivo',
                    'code' => 500,
                    'e' => $exception
                ];
            }
        }

        // ... persist la variable $usuario o cualquier otra tarea

        return $this->resJson($data);
    }

    public function recogerimagen(Request $request)
    {
        $fileName = $request->get('imagen');
        if($fileName== 'null'){
            $fileName='fotonull.png';
        }
//        $params = json_decode($json);
//        $fileName = (!empty($params->imagen)) ? $params->imagen : 'fotonull.png';
//        $cvDir=$this->getParameter('img_user');
//        $data=[
//          'cvdir'=>$cvDir,
//          'file'=>$fileName
//        ];
//        return $this->json($data);
//        $publicResourcesFolderPath = $this->get('kernel')->getRootDir() . '/../web/public-resources/';
        $path = $this->getParameter('img_user');

        return new BinaryFileResponse($path . $fileName);
        return $this->json($path);
    }
//$filename = "TextFile.txt";
//
}
