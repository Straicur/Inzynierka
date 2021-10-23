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
 * @UniqueEntity(fields={"title"}, message="There is already an Institution with this name")
 *
 * @ORM\Table(name="AudiobookInfo")
 *
 */

class AudiobookInfo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="audiobook_info_id", type="integer", nullable=false)
     */
    private $audiobook_info_id;
    /**
     * @ORM\ManyToOne(targetEntity="UserInfo")
     * @ORM\JoinColumn(name="user_info_id", referencedColumnName="user_info_id")
     */
    private $user_info_id;
    /**
     * @ORM\OneToMany(targetEntity="Audiobook", mappedBy="parent")
     * @ORM\JoinColumn(name="audiobook_id", referencedColumnName="audiobook_id")
     */
    private $audiobook_id;
    /**
     * @ORM\Column(name="part_nr",type="integer", nullable=false)
     */
    private $part_nr;

    /**
     * @ORM\Column(name="ended_Tim",type="time", nullable=false)
     */
    private $ended_Time;
    /**
     * @ORM\Column(name="watching_date",type="date", nullable=false)
     */
    private $watching_date;

    function __construct($user_info_id,$audiobook_id,$part_nr,$ended_Time,$watching_date){
        $this->user_info_id = $user_info_id;
        $this->audiobook_id = $audiobook_id;
        $this->part_nr = $part_nr;
        $this->ended_Time = $ended_Time;
        $this->watching_date = $watching_date;
    }

    public function getId()
    {
        return $this->audiobook_info_id;
    }

    public function getPart_nr(): ?int
    {
        return $this->part_nr;
    }

    public function setPart_nr(string $part_nr): self
    {
        $this->part_nr = $part_nr;

        return $this;
    }
    public function getEnded_Time(): ?string
    {
        return $this->ended_Time;
    }

    public function setEnded_Time(string $ended_Time): self
    {
        $this->ended_Time = $ended_Time;

        return $this;
    }
    public function getWatching_date(): ?string
    {
        return $this->watching_date;
    }

    public function setWatching_date(string $watching_date): self
    {
        $this->watching_date = $watching_date;

        return $this;
    }
    public function getUser_info_id(): ?int
    {
        return $this->user_info_id;
    }

    public function setUser_info_id(?UserInfo $user_info_id): self
    {
        $this->user_info_id = $user_info_id;

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
