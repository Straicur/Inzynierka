<?php

namespace App\Tools;

use App\Entity\AdminUser;
use App\Entity\Institution;
use App\Entity\User;
use JMS\Serializer\SerializerBuilder;


/**
 * Class InstitutionActionsTool
 *
 * @package App\Tools
 */
class InstitutionActionsTool
{
    //metoda zwracająca ilość rekordów dla rejestracji dla użytkownika i admina
    //i w rejestracji wywołam metodę dla tego i pobiore z instytucji maxa i sprawdze czy nie przekracza
    public static function maxAccounts($doctrine , bool $admin=false): int
    {
        $entityManager = $doctrine;
        $dbTool = new DBTool($entityManager);
        $institution = $dbTool->findBy(Institution::class, ["name" => $_ENV['INSTITUTION_NAME']]);

        $maxadmin=$institution[0]->getMax_admins();
        $maxusers=$institution[0]->getMax_users();
        if($admin){

            $adminUsers = $dbTool->findBy(AdminUser::class, ["institution_id" => $institution[0]->getId()]);
            if($maxadmin<=count($adminUsers)){
                return false;
            }
            else{
                return true;
            }

        }
        else{
            $allUsers = $dbTool->findBy(User::class, ["institution_id" => $institution[0]->getId()]);
            if($maxusers<=count($allUsers)){
                return false;
            }
            else{
                return true;
            }
        }
    }
}