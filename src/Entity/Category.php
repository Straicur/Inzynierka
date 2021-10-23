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
 * @UniqueEntity(fields={"name"})
 *
 * @ORM\Table(name="Category")
 *
 */

class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="category_id", type="integer", nullable=false)
     */
    private $category_id;
    /**
     * @ORM\ManyToOne(targetEntity="Institution")
     * @ORM\JoinColumn(name="institution_id", referencedColumnName="institution_id")
     */
    private $institution_id;

    /**
     * @ORM\Column(name="name",type="string", length=180, unique=true, nullable=false)
     */
    private $name;

    public function getId()
    {
        return $this->category_id;
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
    public function getInstitution_id(): ?int
    {
        return $this->institution_id;
    }

    public function setInstitution_id(?Institution $institution_id): self
    {
        $this->institution_id = $institution_id;

        return $this;
    }
}
