<?php

namespace App\Model;

use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

class UserInfoSuccessModel{
    /**
     * @var array
     *
     * @JMSA\Type("array<App\JsonModels\GetUserJsonModel>")
     *
     * @SWG\Property(property="user-info",type="array", @SWG\Items(ref=@SWG\Schema(ref=@API\Model(type=App\JsonModels\GetUserJsonModel::class))), description="Array of available sets");
     *
     */
    public $get_user_data;

    /**
     * @param array $get_user_data
     */
    public function __construct(array $get_user_data = []){
        $this->get_user_data = $get_user_data;
    }
}