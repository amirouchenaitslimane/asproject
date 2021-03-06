<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface,\Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $fullName;
    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     * @Assert\NotBlank()
     */
    private $username;
    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     *  @Assert\Email(
     *     message = "L'email '{{ value }}' n'est pas valide !.",
     *     checkMX = true
     * )
     */
    private $email;
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\Length(
     *      min = 4,     *
     *      minMessage = "Le mot de passe introduit doit etre superieur á  {{ limit }}  charactéres",
     *  )
     */
    private $password;
    /**
     * @var array
     *
     * @ORM\Column(type="array")
     */
    private $roles = [];

    public function __construct()
    {
        $this->roles = ['ROLE_USER'];
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }
    public function getFullName()
    {
        return $this->fullName;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
    /**
     * Returns the roles or permissions granted to the user for security.
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        if(empty($roles)){
            $roles[] = 'ROLE_USER';
        }
        return array_unique($roles);
    }
    public function setRoles(array $roles): void
    {
        if(empty($roles)){
            $this->roles = 'ROLE_USER';
        }
        $this->roles = $roles;
    }
    /**
     * Returns the salt that was originally used to encode the password.
     *
     * {@inheritdoc}
     */
    public function getSalt(): ?string
    {
        // See "Do you need to use a Salt?" at https://symfony.com/doc/current/cookbook/security/entity_provider.html
        // we're using bcrypt in security.yml to encode the password, so
        // the salt value is built-in and you don't have to generate one
        return null;
    }
    /**
     * Removes sensitive data from the user.
     *
     * {@inheritdoc}
     */
    public function eraseCredentials(): void
    {
        // if you had a plainPassword property, you'd nullify it here
        // $this->plainPassword = null;
    }
    /**
     * {@inheritdoc}
     */
    public function serialize(): string
    {
        // add $this->salt too if you don't use Bcrypt or Argon2i
        return serialize([$this->id, $this->username, $this->password]);
    }
    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized): void
    {
        // add $this->salt too if you don't use Bcrypt or Argon2i
        [$this->id, $this->username, $this->password] = unserialize($serialized, ['allowed_classes' => false]);
    }
}
