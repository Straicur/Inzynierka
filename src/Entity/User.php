<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\NamedQuery;
use Doctrine\ORM\Mapping\NamedQueries;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 *
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 *
 * @ORM\Table(name="User")
 *
 * @NamedQueries({
 *    @NamedQuery(name="activeUsers", query="SELECT u FROM App:User u WHERE u.isVerified = true"),
 *    @NamedQuery(name="unactiveUsers", query="SELECT u FROM App:User u WHERE u.isVerified = true"),
 *    @NamedQuery(name="loginUser", query="SELECT u FROM App:User u WHERE u.email = :email AND u.password = :password AND u.isVerified = true")
 * })
 */

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $user_id;

    /**
     * @ORM\Column(name="email",type="string", length=180, unique=true, nullable=false)
     */
    private $email;

    /**
     * @ORM\Column(name="roles",type="json", nullable=false)
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(name="password",type="string", nullable=false)
     */
    private $password;

    /**
     * @ORM\Column(name="isVerified",type="boolean")
     */
    private $isVerified = false;
    /**
     * @ORM\ManyToOne(targetEntity="Institution")
     * @ORM\JoinColumn(name="institution_id", referencedColumnName="institution_id")
     */
    private $institution_id;

    public function getId(): ?int
    {
        return $this->user_id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
    public function getInstitutionId(): ?Institution
    {
        return $this->institution_id;
    }

    public function setInstitutionId(?Institution $institution_id): self
    {
        $this->institution_id = $institution_id;

        return $this;
    }
}
