<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

class LoadUserData implements ORMFixtureInterface
{
    /**
    *
    * @param ObjectManager $manager
    */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setName('Admin');
        $user->setPassword('1234');
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);


        $user = new User();
        $user->setName('Page1');
        $user->setPassword('1234');
        $user->setRoles(['ROLE_PAGE_1']);
        $manager->persist($user);

        $user = new User();
        $user->setName('Page2');
        $user->setPassword('1234');
        $user->setRoles(['ROLE_PAGE_2']);
        $manager->persist($user);

        $manager->flush();
    }

}