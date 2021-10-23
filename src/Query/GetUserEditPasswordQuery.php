<?php

namespace App\Query;

use App\Annotations\DataRequired;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation as JMSA;

/**
 * Class GetUserEditPasswordQuery
 * @package App\Query
 */
class GetUserEditPasswordQuery
{
    /**
     * @var string
     *
     * @JMSA\Type("string")
     *
     * @DataRequired
     *
     * @SWG\Property(type="string", maxLength=255, description="Token")
     */
    public $token;
    /**
     * @var string
     *
     * @JMSA\Type("string")
     *
     * @DataRequired
     *
     * @SWG\Property(type="string", maxLength=255, description="old_password")
     */
    public $old_password;
    /**
     * @var string
     *
     * @JMSA\Type("string")
     *
     * @DataRequired
     *
     * @SWG\Property(type="string", maxLength=255, description="new_password")
     */
    public $new_password;
}