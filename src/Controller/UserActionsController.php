<?php

namespace App\Controller;

use App\Entity\AudiobookInfo;
use App\Entity\Institution;
use App\Entity\MyList;
use App\Entity\User;
use App\Entity\UserInfo;
use App\JsonModels\GetUserJsonModel;
use App\Model\AdminAuthSuccessModel;
use App\Model\UserInfoSuccessModel;
use App\Tools\DBTool;
use App\Tools\UserActionsTool;
use Symfony\Component\Asset\Package;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * Class UserActionsController
 * @package App\Controller
 */
class UserActionsController extends MyController
{
    /**
     * Endpoint umożliwiający użytkownikowi zmianę hasła po zalogowaniu
     *
     * @Route("/user/edit_password", name="edit_password", methods={"POST"})
     *
     * @SWG\Parameter(
     *     name="token_json",
     *     in="body",
     *     @Model(type=App\Query\GetUserEditPasswordQuery::class)
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Token was correct"
     * )
     *
     * @SWG\Response(
     *     response=400,
     *     description="The server could not understand the request due to invalid syntax"
     * )
     * @SWG\Response(
     *     response=401,
     *     description="Unauthorized action user"
     * )
     *
     * @SWG\Response(
     *     response=501,
     *     description="Service configuration is incorrect"
     * )
     *
     * @SWG\Tag(name="Admin EP")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function userEditPassword(Request $request): Response{
        $object = $this->getJsonData($request,'App\\Query\\GetUserEditPasswordQuery');

        list($allProvided, $missingAttributes) = $this->checkRrequiredDataFromQuery($object);

        if($allProvided){
            if ($this->authorizeToken($object->token)) {
                $entityManager = $this->getDoctrine();
                $userTool = new UserActionsTool($entityManager);
                $dbTool = new DBTool($entityManager);
                $user = $userTool->getUserByToken($object->token);
                try {

                    $em = $dbTool->getEntityManager();
                    $transaction = $em->getConnection();
                    $transaction->beginTransaction();

                    if($user[0]->getPassword()===$object->old_password)
                    {
                        $user[0]->setPassword($object->new_password);

                        $dbTool->insertData($user[0]);

                        $transaction->commit();
                    }
                    else{
                        $transaction->rollBack();

                        return $this->getResponse(null, 500);
                    }

                }
                catch (\Exception $e) {

                    return $this->getResponse(null, 500);
                }
                return $this->getResponse();
            }
            else{
                return $this->getResponse(null, 401);
            }
        }
        else{
            return $this->getResponse(null, 400);
        }
    }
    /**
     *
     * Endpoint umożliwiający użytkownikowi usunięcie z bazy jego konta
     *
     * @Route("/user/delete", name="user_delete_account", methods={"POST"})
     *
     * @SWG\Parameter(
     *     name="token_json",
     *     in="body",
     *     @Model(type=App\Query\GetSetsQuery::class)
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Token was correct"
     * )
     *
     * @SWG\Response(
     *     response=400,
     *     description="The server could not understand the request due to invalid syntax"
     * )
     * @SWG\Response(
     *     response=401,
     *     description="Unauthorized action user"
     * )
     *
     * @SWG\Response(
     *     response=501,
     *     description="Service configuration is incorrect"
     * )
     *
     * @SWG\Tag(name="Admin EP")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function userDelete(Request $request): Response{
        $object = $this->getJsonData($request,'App\\Query\\GetLoggedUserQuery');

        list($allProvided, $missingAttributes) = $this->checkRrequiredDataFromQuery($object);

        if($allProvided){
            if ($this->authorizeToken($object->token)) {


                $entityManager = $this->getDoctrine();
                $userTool = new UserActionsTool($entityManager);
                $dbTool = new DBTool($entityManager);
                $user = $userTool->getUserByToken($object->token);

                if($user){
                    //TODO Tu jest do pomyślenia jak u admina
                    $em = $dbTool->getEntityManager();
                    $transaction = $em->getConnection();
                    $transaction->beginTransaction();

                    try {

                        $dbTool->removeData($user[0],false);
                        $transaction->commit();
                        $userInfo = $dbTool->findBy(UserInfo::class, ["user_id" => $user[0]->getId()]);

                        $dbTool->removeData($user[0]);
                        if($userInfo[0])
                        {
                            $dbTool->removeData($user[0],false);
                            $dbTool->removeData($userInfo[0]);
                        }
//                        try{
//                            $userMylist = $dbTool->findBy(MyList::class, ["user_id" => $user[0]->getId()]);
//                            if($userMylist[0])
//                            {
//                                $dbTool->removeData($userMylist[0]);
//                            }
//                            $userAudiobookInfo = $dbTool->findBy(AudiobookInfo::class, ["user_info_id" => $userInfo[0]->getId()]);
//                            if($userAudiobookInfo)
//                            {
//                                foreach ($userAudiobookInfo as $userAI){
//                                    $dbTool->removeData($userAI);
//                                }
//                            }
//                        }
//                        catch (\Exception $e) {
//                            $transaction->rollBack();
//                            return $this->getResponse(null, 500);
//                        }
                        $transaction->commit();
                        return $this->getResponse();
                    }
                    catch (\Exception $e) {

                        return $this->getResponse(null, 500);
                    }
                }
                else{
                    return $this->getResponse(null,500);
                }
            }
            else{
                return $this->getResponse(null,401);
            }
        }
        else{
            return $this->getResponse(null,400);
        }

    }
    /**
     * Endpoint który służy do zczytywania danych o audiobookach dla zalogowanego uzytkownika
     *
     * @Route("/user/getData", name="user_get_audiobookData", methods={"POST"})
     *
     * @SWG\Parameter(
     *     name="token_json",
     *     in="body",
     *     @Model(type=App\Query\GetUserAudiobookInfoQuery::class)
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Token was correct"
     * )
     *
     * @SWG\Response(
     *     response=400,
     *     description="The server could not understand the request due to invalid syntax"
     * )
     * @SWG\Response(
     *     response=401,
     *     description="Unauthorized action user"
     * )
     *
     * @SWG\Response(
     *     response=501,
     *     description="Service configuration is incorrect"
     * )
     *
     * @SWG\Tag(name="Admin EP")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function userGetAudiobookData(Request $request): Response{
        $object = $this->getJsonData($request,'App\\Query\\GetUserAudiobookInfoQuery');

        list($allProvided, $missingAttributes) = $this->checkRrequiredDataFromQuery($object);

        if($allProvided) {
            if ($this->authorizeToken($object->token)) {
                $entityManager = $this->getDoctrine();
                $userTool = new UserActionsTool($entityManager);
                if($userTool -> saveUserData($entityManager,$object))
                {
                    return $this->getResponse();
                }
                else{
                    return $this->getResponse(null,500);
                }
            }
            else{
                return $this->getResponse(null,401);
            }
        }
        else{
        return $this->getResponse(null,400);
        }

    }
}