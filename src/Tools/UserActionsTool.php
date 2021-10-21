<?php

namespace App\Tools;

use App\Entity\AdminUser;
use App\Entity\Institution;
use App\Entity\User;
use JMS\Serializer\SerializerBuilder;


/**
 * Class UserActionsTool
 *
 * @package App\Tools
 */
class UserActionsTool
{
    public static function getUserByToken($doctrine,$token)
    {
        $entityManager = $doctrine;
        $dbTool = new DBTool($entityManager);
        $token = $dbTool->findBy(Institution::class, ["token" => $token,"active"=>true]);

        $users = $dbTool->findBy(User::class, ["institution_id" => $token[0]->getTokenId()]);
        return $users[0];
    }
}