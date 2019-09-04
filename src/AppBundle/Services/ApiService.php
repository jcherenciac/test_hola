<?php


namespace AppBundle\Services;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class ApiService
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * ApiService constructor.
     * @param EntityManagerInterface $em
     * @param SerializerInterface $serializer
     */
    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $this->em = $em;
        $this->serializer = $serializer;
    }

    /**
     * @return array
     */
    public function list()
    {
        return $this->em
            ->getRepository(User::class)
            ->findAll();
    }

    /**
     * @param $id
     * @return array
     */
    public function get($id)
    {
        $response = [];
        $user = $this->em
            ->getRepository(User::class)
            ->find($id);

        if (!$user) {
            $response['statusCode'] = Response::HTTP_NOT_FOUND;
            $response['statusMsg'] = 'Usuario no encontrado';
            return $response;
        }

        $response['statusCode'] = Response::HTTP_OK;
        $response['statusMsg'] = 'Usuario encontrado.';
        $response['data'] = json_decode($this->serializer->serialize($user, 'json'));
        return $response;
    }

    /**
     * @param $data
     * @return array
     */
    public function create($data)
    {
        $response = [];
        $user = $this->serializer->deserialize($data, User::class, 'json');
        if ($user->isValid()) {
            $this->em->persist($user);
            $this->em->flush();

            $response['statusCode'] = Response::HTTP_OK;
            $response['statusMsg'] = 'Usuario creado.';
            return $response;
        }
        $response['statusCode'] = Response::HTTP_PARTIAL_CONTENT;
        $response['statusMsg'] = 'Datos incompletos o incorrectos.';
        return $response;
    }

    /**
     * @param $data
     * @param $id
     * @return array
     */
    public function update($data, $id)
    {
        $response = [];
        $user = $this->em
            ->getRepository(User::class)
            ->find($id);

        $newUserData = $this->serializer->deserialize($data, User::class, 'json');
        if ($newUserData->isValid()) {
            $user->setName($newUserData->getName());
            $user->setPassword($newUserData->getPassword());
            $user->setRoles($newUserData->getRoles());

            $this->em->persist($user);
            $this->em->flush();

            $response['statusCode'] = Response::HTTP_OK;
            $response['statusMsg'] = 'Usuario actualizado.';
            return $response;
        }
        $response['statusCode'] = Response::HTTP_PARTIAL_CONTENT;
        $response['statusMsg'] = 'Datos incompletos o incorrectos.';
        return $response;
    }

    /**
     * @param $id
     * @return array
     */
    public function remove($id)
    {
        $response = [];
        $user = $this->em
            ->getRepository(User::class)
            ->find($id);

        if (!$user) {
            $response['statusCode'] = Response::HTTP_NOT_FOUND;
            $response['statusMsg'] = 'Usuario no encontrado';
            return $response;
        }
            $this->em->remove($user);
            $this->em->flush();

        $response['statusCode'] = Response::HTTP_OK;
        $response['statusMsg'] = 'Usuario borrado';
        return $response;
    }
}
