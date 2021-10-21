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
class GetUserInfoQuery{
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

}