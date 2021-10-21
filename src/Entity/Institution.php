<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\NamedQuery;
use Doctrine\ORM\Mapping\NamedQueries;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity
 *
 * @UniqueEntity(fields={"name"}, message="There is already an Institution with this name")
 *
 * @ORM\Table(name="Institution")
 *
 */

class Institution
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="institution_id", type="integer", nullable=false)
     */
    private $institution_id;

    /**
     * @ORM\Column(name="name",type="string", length=180, unique=true, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(name="email",type="string", nullable=false)
     */
    private $email;
    /**
     * @ORM\Column(name="telephone",type="string", nullable=false)
     */
    private $telephone;
    /**
     * @ORM\Column(name="max_users",type="integer", nullable=false)
     */
    private $max_users;
    /**
     * @ORM\Column(name="max_admins",type="integer", nullable=false)
     */
    private $max_admins;

    public function getId()
    {
        return $this->institution_id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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
    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }
    public function getMax_users(): ?string
    {
        return $this->max_users;
    }

    public function setMax_users(string $max_users): self
    {
        $this->max_users = $max_users;

        return $this;
    }
    public function getMax_admins(): ?string
    {
        return $this->max_admins;
    }

    public function setMax_admins(string $max_admins): self
    {
        $this->max_admins = $max_admins;

        return $this;
    }
}
