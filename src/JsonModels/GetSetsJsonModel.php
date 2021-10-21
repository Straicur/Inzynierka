<?php

namespace App\JsonModels;

use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation as JMSA;

/**
 * Class GetSetsJsonModel
 * @package App\JsonModel
 */
class GetSetsJsonModel{

    /**
     * @var string
     *
     * @JMSA\Type("string")
     *
     * @SWG\Property(type="string", maxLength=32, description="Access_token");
     */
    public $access_token;

    /**
     * @var string
     *
     * @JMSA\Type("string")
     *
     * @SWG\Property(type="string", maxLength=255, description="name");
     */
    public $name;
}