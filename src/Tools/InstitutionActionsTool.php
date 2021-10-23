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
    /**
     *
     * Metoda służąca do sprawdzenia czy nie przekroczono maksymalnej ilość rejesdtracji adminów i użytkowników dla podanej instytucji
     *
     * @param $doctrine
     * @param bool $admin
     * @return int
     */
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