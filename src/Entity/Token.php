<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\NamedQuery;
use Doctrine\ORM\Mapping\NamedQueries;
use DateTime;
//named query do sprawdzania aktywnych
/**
 * @ORM\Entity
 * @ORM\Table(name="token")
 *  @NamedQueries({
 *     @NamedQuery(name="active", query="SELECT t FROM App:Token t WHERE t.active = 1"),
 *     @NamedQuery(name="unactive", query="SELECT t FROM App:Token t WHERE t.active = 0")
 * })
 */
class Token
{
    function __construct($user,$token) {
        $this->token = $token;
        $this->admin_id = $user;
        $this->created_at = new DateTime('NOW');
        $this->active_to = new DateTime('NOW');
        $this->active_to->add(new \DateInterval('PT10M'));
        $this->active=true;
    }
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="token_id", type="integer", nullable=false)
     */
    private $token_id;

    /**
     * @ORM\ManyToOne(targetEntity="AdminUser")
     * @ORM\JoinColumn(name="admin_id", referencedColumnName="admin_id")
     */
    private $admin_id;

    /**
     * @ORM\Column(name="token",type="string", length=255, nullable=false)
     */
    private $token;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $created_at;

    /**
     * @ORM\Column(name="active_to", type="datetime", nullable=false)
     */
    private $active_to;

    /**
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;

    public function getTokenId(): ?int
    {
        return $this->token_id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getActiveTo(): ?\DateTimeInterface
    {
        return $this->active_to;
    }

    public function setActiveTo(\DateTimeInterface $active_to): self
    {
        $this->active_to = $active_to;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getUserId(): ?AdminUser
    {
        return $this->admin_id;
    }

    public function setUserId(?AdminUser $admin_id): self
    {
        $this->admin_id = $admin_id;

        return $this;
    }


}
