<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * AppBundle\Entity\User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
//const ROLE_LIST = ['ADMIN','PAGE_1','PAGE_2'];

class User implements UserInterface
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="array")
     */
    private $roles;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    public function getUsername()
    {
        return $this->name;
    }

    public function getSalt()
    {
        return null;
    }


    public function eraseCredentials()
    {
    }


    /**
     * @return bool
     */
    public function isValid(){
        $isValidName = !empty($this->getName());
        $isValidPassword = !empty($this->getPassword());
        $isValidRoleList = !empty($this->getRoles()) && $this->isValidRole();

        return $isValidName
            && $isValidPassword
            && $isValidRoleList;
    }

    /**
     * @return bool
     */
    private function isValidRole(){
        $roleList = ['ROLE_ADMIN','ROLE_PAGE_1','ROLE_PAGE_2'];
        foreach( $this->getRoles() as $role ){
            if(!in_array($role,$roleList)){
                return false;
            }
        }
        return true;


    }
}

