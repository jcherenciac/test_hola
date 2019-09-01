<?php


namespace AppBundle;


use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class ApiService
{
    protected $em;
    /**
     * @var Serializer
     */
    private $serializer;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);
    }

    public function list(){
        return $this->em
            ->getRepository(User::class)
            ->findAll();
    }

    public function create($data)
    {
        $user = $this->serializer->deserialize($data, User::class, 'json');
        if ( $user->isValid() ){
            $this->em->persist($user);
            $this->em->flush();
        }
    }

    public function update($data,$id)
    {
        $user = $this->serializer->deserialize($data, User::class, 'json');
        if ( $user->isValid() ){
            $this->em->persist($user);
            $this->em->flush();
        }
    }

    public function remove($id){
        $user = $this->em
            ->getRepository(User::class)
            ->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
//        $user = $this->em
//            ->getRepository('User')
//            ->find($id);
//        var_dump($user);
    }

}