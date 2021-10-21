<?php

namespace App\JsonModels;

use Swagger\Annotations as SWG;

/**
 * Class GetUserJsonModel
 *
 * @package App\JsonModels
 */
class GetUserJsonModel{
    /**
     * @var integer
     *
     * @SWG\Property(type="integer", description="Id of User")
     */
    private $id;

    /**
     * @var string
     *
     * @SWG\Property(type="string", maxLength=255, description="Email of User")
     */
    private $email;

    /**
     * @var array
     *
     * @SWG\Property(type="array",description="Roles of User",@SWG\Items(type="string"))
     */
    private $roles;

    /**
     * @var string
     *
     * @SWG\Property(type="string", description="Password of User")
     */
    private $password;
    /**
     * @var bool
     *
     * @SWG\Property(type="boolean", description="Bool if User is verified")
     */
    private $is_verified;

    function __construct(int $id,string $email,array $roles,string $password, bool $is_verified)
    {
        $this->id = $id;
        $this->email = $email;
        $this->roles = $roles;
        $this->password = $password;
        $this->is_verified = $is_verified;
    }


}

