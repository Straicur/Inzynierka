<?php

namespace App\JsonModels;

use Swagger\Annotations as SWG;

/**
 * Class GetSetsModel
 *
 * @package App\JsonModels
 */
class GetSetsModel{
    /**
     * @var string
     *
     * @SWG\Property(type="string", maxLength=255, description="Catalog_name")
     */
    private $catalog_name;

    /**
     * @var string
     *
     * @SWG\Property(type="string", maxLength=255, description="Access_token to this catalog")
     */
    private $access_token;

    /**
     * @var string
     *
     * @SWG\Property(type="string", maxLength=255, description="System folder_dir")
     */
    private $folder_dir;

    /**
     * @var int
     *
     * @SWG\Property(type="integer", description="Amount of books in catalog")
     */
    private $amount;


    function __construct(string $catalog_name,string $access_token,string $folder_dir,int $amount)
    {
        $this->catalog_name=$catalog_name;
        $this->access_token=$access_token;
        $this->folder_dir=$folder_dir;
        $this->amount=$amount;
    }

    public function getCatalog_name(): string
    {
        return $this->catalog_name;
    }

    public function setCatalog_name($catalog_name){
        $this->catalog_name = $catalog_name;
    }
    public function getAccess_token(): string
    {
        return $this->access_token;
    }

    public function setAccess_token($access_token){
        $this->access_token = $access_token;
    }
    public function getFolder_dir(): string
    {
        return $this->folder_dir;
    }

    public function setFolderDir($folder_dir){
        $this->folder_dir = $folder_dir;
    }
    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount($amount){
        $this->amount = $amount;
    }

}

