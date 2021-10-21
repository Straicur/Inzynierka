<?php

namespace App\JsonModels;

use Swagger\Annotations as SWG;

/**
 * Class GetSetsAudiobooksModel
 *
 * @package App\JsonModels
 */
class GetSetsAudiobooksModel{
    /**
     * @var string
     *
     * @SWG\Property(type="string", maxLength=255, description="book_name")
     */
    private $book_name;

    /**
     * @var string
     *
     * @SWG\Property(type="string", maxLength=255, description="Size of mp3 file")
     */
    private $size;

    /**
     * @var string
     *
     * @SWG\Property(type="string", maxLength=255, description="Duration of mp3 file")
     */
    private $duration;

    function __construct(string $book_name, string $size, string $duration)
    {
        $this->book_name = $book_name;
        $this->size = $size;
        $this->duration = $duration;
    }
    public function getBook_name(): string
    {
        return $this->book_name;
    }

    public function setBook_name($book_name){
        $this->book_name = $book_name;
    }
    public function getSize(): string
    {
        return $this->size;
    }

    public function setSize($size){
        $this->size = $size;
    }

    public function getDuration(): string
    {
        return $this->duration;
    }

    public function setDuration($duration){
        $this->duration = $duration;
    }
}
