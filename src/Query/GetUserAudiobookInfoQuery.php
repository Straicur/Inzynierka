<?php

namespace App\Query;

use App\Annotations\DataRequired;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation as JMSA;

/**
 * Class GetUserAudiobookInfoQuery
 * @package App\Query
 */
class GetUserAudiobookInfoQuery{

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
     * @JMSA\Type("int")
     *
     * @DataRequired
     *
     * @SWG\Property(type="integer", description="audiobook_id")
     */
    public $audiobook_id;
    /**
     * @var string
     *
     * @JMSA\Type("int")
     *
     * @DataRequired
     *
     * @SWG\Property(type="integer", description="part_nr")
     */
    public $part_nr;
    /**
     * @var string
     *
     * @JMSA\Type("time")
     *
     * @DataRequired
     *
     * @SWG\Property(type="time", description="ended_Time")
     */
    public $ended_Time;
    /**
     * @var string
     *
     * @JMSA\Type("date")
     *
     * @DataRequired
     *
     * @SWG\Property(type="date", description="watching_date")
     */
    public $watching_date;


}
