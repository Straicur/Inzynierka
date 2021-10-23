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
 * @ORM\Table(name="Audiobook")
 *
 */

class Audiobook
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="audiobook_id", type="integer", nullable=false)
     */
    private $audiobook_id;
    /**
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="category_id")
     */
    private $category_id;
    /**
     * @ORM\Column(name="title",type="string", length=180, unique=true, nullable=false)
     */
    private $title;

    /**
     * @ORM\Column(name="year",type="integer", nullable=false)
     */
    private $year;
    /**
     * @ORM\Column(name="publisher",type="string", nullable=false)
     */
    private $publisher;
    /**
     * @ORM\Column(name="comments",type="string", nullable=false)
     */
    private $comments;
    /**
     * @ORM\Column(name="duration",type="string", nullable=false)
     */
    private $duration;
    /**
     * @ORM\Column(name="parts",type="integer", nullable=false)
     */
    private $parts;

    function __construct($category_id,$title,$year,$publisher,$comments,$duration,$parts){
        $this->category_id = $category_id;
        $this->title = $title;
        $this->year = $year;
        $this->publisher = $publisher;
        $this->comments = $comments;
        $this->duration = $duration;
        $this->parts = $parts;
    }

    public function getId()
    {
        return $this->audiobook_id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(string $year): self
    {
        $this->year = $year;

        return $this;
    }
    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    public function setPublisher(string $publisher): self
    {
        $this->publisher = $publisher;

        return $this;
    }
    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(string $comments): self
    {
        $this->comments = $comments;

        return $this;
    }
    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }
    public function getParts(): ?int
    {
        return $this->parts;
    }

    public function setParts(string $parts): self
    {
        $this->parts = $parts;

        return $this;
    }
    public function getCategory_id(): ?int
    {
        return $this->category_id;
    }

    public function setCategory_id(?Category $category_id): self
    {
        $this->category_id = $category_id;

        return $this;
    }
}
