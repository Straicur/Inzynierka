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
 * @ORM\Table(name="UserInfo")
 *
 */

class UserInfo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="audiobook_id", type="integer", nullable=false)
     */
    private $user_info_id;
    /**
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     */
    private $user_id;

    public function getId(): ?int
    {
        return $this->user_info_id;
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
}