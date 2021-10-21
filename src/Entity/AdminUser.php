<?php

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\NamedQuery;
use Doctrine\ORM\Mapping\NamedQueries;
use DateTime;
/**
 * @ORM\Entity
 *
 * @ORM\Table(name="AdminUser")
 *
 * @NamedQueries({
 *     @NamedQuery(name="checkLogin", query="SELECT u FROM App:AdminUser u LEFT JOIN App:AdminPassword p WITH p.admin_id = u.admin_id WHERE u.login = :login AND p.adminPassword = :passwd")
 * })
 */
class AdminUser{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="admin_id", type="integer", nullable=false)
     */
    private $admin_id;

    /**
     * @ORM\Column(name="login",type="string", length=255, nullable=false)
     */
    private $login;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $created_at;
    /**
     * @ORM\ManyToOne(targetEntity="Institution")
     * @ORM\JoinColumn(name="institution_id", referencedColumnName="institution_id")
     */
    private $institution_id;

    function __construct($login,$institution_id) {
        $this->login = $login;
        $this->created_at = new DateTime('NOW');
        $this->institution_id = $institution_id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->admin_id;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login): void
    {
        $this->login = $login;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    /**
     * @param DateTime $created_at
     */
    public function setCreatedAt(DateTime $created_at): void
    {
        $this->created_at = $created_at;
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
