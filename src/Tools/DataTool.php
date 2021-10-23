<?php

namespace App\Tools;

use App\Entity\AdminUser;
use JMS\Serializer\SerializerBuilder;


/**
 * Class DataTool
 *
 * @package App\Tools
 */
class DataTool
{
    /**
     *
     * Metoda która desarilizuje dane na podstawie podanej klasy
     *
     * @param $data
     * @param $className
     * @return mixed
     */
    public static function getJsonData($data, $className)
    {
        $serializer = SerializerBuilder::create()->build();

        $serializedObject = $serializer->deserialize($data, $className, 'json');

        return $serializedObject;
    }

    /**
     *
     * Metoda która serializuje dane do jsona
     *
     * @param $model
     * @return string
     */
    public static function makeJsonData($model)
    {
        $serializer = SerializerBuilder::create()->build();

        $serializedModel = $serializer->serialize($model, 'json');

        return $serializedModel;
    }
}
