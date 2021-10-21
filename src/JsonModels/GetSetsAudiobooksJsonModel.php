<?php

namespace App\JsonModels;

use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use JMS\Serializer\Annotation as JMSA;

/**
 * Class GetSetsAudiobooksJsonModel
 * @package App\JsonModel
 */
class GetSetsAudiobooksJsonModel{

    /**
     * @var string
     *
     * @JMSA\Type("string")
     *
     * @SWG\Property(type="string", maxLength=255, description="$filename");
     */
    public $filename;

    /**
     * @var string
     *
     * @JMSA\Type("string")
     *
     * @SWG\Property(type="string", maxLength=255, description="$version");
     */
    public $version;

    /**
     * @var string
     *
     * @JMSA\Type("string")
     *
     * @SWG\Property(type="string", maxLength=255, description="$title");
     */
    public $title;

    /**
     * @var string
     *
     * @JMSA\Type("string")
     *
     * @SWG\Property(type="string", maxLength=255, description="$album");
     */
    public $album;

    /**
     * @var string
     *
     * @JMSA\Type("string")
     *
     * @SWG\Property(type="string", maxLength=255, description="$author");
     */
    public $author;

    /**
     * @var string
     *
     * @JMSA\Type("string")
     *
     * @SWG\Property(type="string", maxLength=255, description="$albumAuthor");
     */
    public $album_author;

    /**
     * @var string
     *
     * @JMSA\Type("string")
     *
     * @SWG\Property(type="string", maxLength=255, description="$track");
     */
    public $track;

    /**
     * @var string
     *
     * @JMSA\Type("string")
     *
     * @SWG\Property(type="string", maxLength=255, description="$year");
     */
    public $year;

    /**
     * @var string
     *
     * @JMSA\Type("string")
     *
     * @SWG\Property(type="string", maxLength=255, description="$desc");
     */
    public $desc;

    /**
     * @var string
     *
     * @JMSA\Type("string")
     *
     * @SWG\Property(type="string", maxLength=255, description="$genre");
     */
    public $genre;

    /**
     * @var string
     *
     * @JMSA\Type("string")
     *
     * @SWG\Property(type="string", maxLength=255, description="$publisher");
     */
    public $publisher;

    /**
     * @var string
     *
     * @JMSA\Type("string")
     *
     * @SWG\Property(type="string", maxLength=255, description="$comments");
     */
    public $comments;

    /**
     * @var string
     *
     * @JMSA\Type("string")
     *
     * @SWG\Property(type="string", maxLength=255, description="$duration");
     */
    public $duration;

    /**
     * @var string
     *
     * @JMSA\Type("string")
     *
     * @SWG\Property(type="string", maxLength=255, description="$size");
     */
    public $size;

}
