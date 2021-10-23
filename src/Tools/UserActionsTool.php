<?php

namespace App\Tools;

use App\Entity\AdminUser;
use App\Entity\AudiobookInfo;
use App\Entity\Institution;
use App\Entity\User;
use App\Entity\UserInfo;
use App\Entity\UserToken;
use JMS\Serializer\SerializerBuilder;


/**
 * Class UserActionsTool
 *
 * @package App\Tools
 */
class UserActionsTool
{
    private $doctrine;
    private $em;

    /**
     * UserActionsTool constructor.
     *
     * @param $doctrine
     */
    public function __construct($doctrine){
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getManager();
    }

    public function getEntityManager(){
        return $this->em;
    }

    /**
     *
     * Metoda która zwraca użytkownika który zostaje wyszukany za pomocą jego podanego aktywnego tokenu
     *
     * @param $token
     * @return array
     */
    public function getUserByToken($token)
    {
        $dbTool = new DBTool($this->doctrine);
        $token = $dbTool->findBy(UserToken::class, ["token" => $token,"active"=>true]);
        $users = $dbTool->findBy(User::class, ["id" => $token[0]->getUserId()]);

        return [$users];
    }

    /**
     *
     * Metoda która służy do zapisywania danych do Tabeli AudibookInfo
     *
     * @param $doctrine
     * @param $data
     * @return bool
     */
    public function saveUserData($doctrine,$data)
    {
        $dbTool = new DBTool($doctrine);
        $user = self::getUserByToken($data->token);
        $em = $dbTool->getEntityManager();
        $transaction = $em->getConnection();
        $transaction->beginTransaction();
        try {
            $userInfo = $dbTool->findBy(UserInfo::class, ["user_id" => $user[0]]);

            $audiobookInfo = new AudiobookInfo($userInfo, $data->audiobook_id, $data->part_nr, $data->ended_Time, $data->watching_date);
            $dbTool->insertData($audiobookInfo);

            $transaction->commit();

            return true;
        }
        catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }


}