<?php

namespace App\Query;

use App\Annotations\DataRequired;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation as JMSA;

/**
 * Class GetUserInfoQuery
 * @package App\Query
 */
class GetUserEditQuery{
    /**
     * @var string
     *
     * @JMSA\Type("string")
     *
     * @DataRequired
     *
     * @SWG\Property(type="string", maxLength=32, description="Token")
     */
    public $token;
    /**
     * @var array
     *
     * @JMSA\Type("integer")
     *
     * @DataRequired
     *
     * @SWG\Property(type="integer", description="UserID")
     */
    public $id;
    /**
     * @var array
     *
     * @JMSA\Type("array")
     *
     * @DataRequired
     *
     * @SWG\Property(type="array", description="Roles",@SWG\Items(type="string"))
     */
    public $role;
    /**
     * @var string
     *
     * @JMSA\Type("string")
     *
     * @DataRequired
     *
     * @SWG\Property(type="string", maxLength=255, description="Password")
     */
    public $password;
    /**
     * @var string
     *
     * @JMSA\Type("boolean")
     *
     * @DataRequired
     *
     * @SWG\Property(type="boolean", description="IsVerifide")
     */
    public $is_verified;
}
