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
 * @ORM\Table(name="MyList")
 *
 */

class MyList
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="audiobook_id", type="integer", nullable=false)
     */
    private $my_list_id;
    /**
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     */
    private $user_id;
    /**
     * @ORM\OneToMany(targetEntity="Audiobook", mappedBy="parent")
     * @ORM\JoinColumn(name="audiobook_id", referencedColumnName="audiobook_id")
     */
    private $audiobook_id;
    public function getId(): ?int
    {
        return $this->my_list_id;
    }
    public function getUser_id(): ?int
    {
        return $this->user_id;
    }

    public function setUser_id(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }
    public function getAudiobook_id(): ?int
    {
        return $this->audiobook_id;
    }

    public function setAudiobook_id(?Audiobook $audiobook_id): self
    {
        $this->audiobook_id = $audiobook_id;

        return $this;
    }
}