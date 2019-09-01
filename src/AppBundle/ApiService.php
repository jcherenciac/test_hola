<?php


namespace AppBundle;


use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;


class ApiService
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function list(){
//        $em = $this->getDoctrine()->getManager();
        return $this->em
            ->getRepository(User::class)
            ->findAll();
    }

}