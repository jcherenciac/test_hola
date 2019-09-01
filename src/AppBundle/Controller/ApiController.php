<?php

namespace AppBundle\Controller;

use AppBundle\ApiService;
use AppBundle\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/api", name="api_")
 */

class ApiController extends Controller
{
    protected $serializer;
//    private $roles = ['ADMIN','PAGE_1','PAGE_2'];
    private $apiService;


    public function __construct(ApiService $apiService)
    {

        $this->apiService = $apiService;
    }

    /**
     * @Route("/users", name="list", methods={"GET"})
     */
    public function listAction()
    {
        $users = $this->apiService->list();
        $responseJson = $this->serializer->serialize($users,'json');
        return new Response($responseJson, Response::HTTP_OK, ['content-type' => 'application/json']);
    }

    /**
     * @Route("/user/{id}", name="get", methods={"GET"})
     * @param $id
     * @return Response
     */
    public function getAction($id)
    {
        $users = $this->apiService->get($id);
        $responseJson = $this->serializer->serialize($users,'json');
        return new Response($responseJson, Response::HTTP_OK, ['content-type' => 'application/json']);
    }

    /**
     * @Route("/new", name="create", methods={"POST"})
     */
    public function createAction(Request $request)
    {

        $data = $request->getContent();
        $response = $this->apiService->create($data);
        return new JsonResponse($response);
    }

    /**
     * @Route("/update/{id}", name="update", methods={"PUT"})
     */
    public function updateAction(Request $request,$id)
    {



    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request,$id)
    {
        $response = $this->apiService->remove($id);
        return new Response($response, Response::HTTP_OK, ['content-type' => 'application/json']);
    }

}
