<?php

namespace AppBundle\Controller;

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
    private $roles = ['ADMIN','PAGE_1','PAGE_2'];


    public function __construct()
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
     * @Route("/users", name="list", methods={"GET"})
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        $responseJson = $this->serializer->serialize($users,'json');
        return new Response($responseJson, Response::HTTP_OK, ['content-type' => 'application/json']);
    }

    /**
     * @Route("/user/{id}", name="get", methods={"GET"})
     */
    public function getAction(Request $request, $id)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/new", name="create", methods={"POST"})
     */
    public function createAction(Request $request)
    {

        $data = $request->getContent();
        $user = $this->serializer->deserialize($data,User::class,'json');
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
//
        return new JsonResponse($user);
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
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

}
