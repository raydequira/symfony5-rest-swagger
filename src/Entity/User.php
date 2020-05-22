<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $number;

    /**
    * @ORM\Column(type="string", length=25, unique=true)
    */
    private $username;
    
    /**
     * @ORM\Column(type="string", length=255)
    */
    private $password;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    /**
      * User constructor.
      * @param $username
      */
     public function __construct(string $username)
     {
      $this->username = $username;
     }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'firstName' => $this->getFirstName(),
            'lastName' => $this->getLastName(),
            'email' => $this->getEmail(),
            'number' => $this->getNumber()
        ];
    }

    /**
    * @param mixed $username
    */
    public function setUsername($username): void
    {
        $this->username = $username;
    
    }

    /**
      * @return string
     */
    public function getUsername()
    {
      return $this->username;
    }

    /**
    * @param $password
    */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
      * @return string|null
    */
    public function getPassword()
    {
      return $this->password;
    }

    /**
      * @return string|null
      */
     public function getSalt()
     {
      return null;
     }

    public function setRoles(array $roles)
    {
        $this->roles = array();

        foreach ($roles as $role) {
            $this->addRole($role);
        }

        return $this;
    }

    public function addRole($role)
    {
        $role = strtoupper($role);
        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    /**
      * @return array|string[]
    */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

     public function eraseCredentials()
     {

     }
}
