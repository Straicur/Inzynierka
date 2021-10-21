<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;
/**
 * @ORM\Entity
 * @ORM\Table(name="adminPassword")
 */
class AdminPassword{
    /**
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="AdminUser")
     * @ORM\JoinColumn(name="admin_id", referencedColumnName="admin_id")
     */
    private $admin_id;

    /**
     * @ORM\Column(type="string", length=513)
     */
    private $adminPassword;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $created_at;

    function __construct($admin_id, $adminPassword) {
        $this->adminPassword = $adminPassword;
        $this->admin_id = $admin_id;
        $this->created_at = new DateTime('NOW');
    }

    /**
     * @return mixed
     */
    public function getAdminId()
    {
        return $this->admin_id;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->adminPassword;
    }

    /**
     * @param mixed $adminPassword
     */
    public function setPassword($adminPassword): void
    {
        $this->adminPassword = $adminPassword;
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

    public function setAdminId(?AdminUser $admin_id): self
    {
        $this->admin_id = $admin_id;

        return $this;
    }

}
