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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * Class AdminUsersActionsController
 * @package App\Controller
 */
class AdminUsersActionsController extends MyController
{
    /**
     * Endpoint dla admina który zwraca listę wszystkich użytkowników podpiętych pod podaną w envie instytucję
     *
     * @Route("/admin/users", name="user_info", methods={"POST"})
     *
     * @SWG\Parameter(
     *     name="token_json",
     *     in="body",
     *     @Model(type=App\Query\GetUserInfoQuery::class)
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Token was correct",
     *     @Model(type=App\Model\AdminAuthSuccessModel::class)
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
    public function userInfo(Request $request): Response{

        $object = $this->getJsonData($request,'App\\Query\\GetUserInfoQuery');

        list($allProvided, $missingAttributes) = $this->checkRrequiredDataFromQuery($object);

        if ($allProvided) {
            if ($this->authorizeToken($object->token, true)) {
                $entityManager = $this->getDoctrine();
                $dbTool = new DBTool($entityManager);

                $institution = $dbTool->findBy(Institution::class, ["name" => $_ENV['INSTITUTION_NAME']]);

                $users = $dbTool->findBy(User::class, ["institution_id" => $institution[0]->getId()]);

                $preparedData=[];
                foreach ($users as $user){
                    $preparedData[]=new GetUserJsonModel($user->getId(),$user->getEmail(),$user->getRoles(),$user->getPassword(),$user->isVerified());
                }
                $res = new UserInfoSuccessModel([$preparedData]);

                return $this->getResponse($this->makeJsonData($res));
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
     * Endpoint dla admina który umożliwia edytowanie danych usera po jego id
     *
     * @Route("/admin/users/edit", name="user_edit", methods={"POST"})
     *
     * @SWG\Parameter(
     *     name="token_json",
     *     in="body",
     *     @Model(type=App\Query\GetUserEditQuery::class)
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
    public function userEdit(Request $request): Response{

        $object = $this->getJsonData($request,'App\\Query\\GetUserEditQuery');

        list($allProvided, $missingAttributes) = $this->checkRrequiredDataFromQuery($object);

        if ($allProvided) {
            if ($this->authorizeToken($object->token, true)) {
                $entityManager = $this->getDoctrine();
                $dbTool = new DBTool($entityManager);
                $institution = $dbTool->findBy(Institution::class, ["name" => $_ENV['INSTITUTION_NAME']]);

                $user = $dbTool->findBy(User::class, ["user_id" => $object->id,"institution_id" => $institution[0]->getId()]);
                try{
                    $em = $dbTool->getEntityManager();
                    $transaction = $em->getConnection();
                    $transaction->beginTransaction();

                    if($user[0]){

                        $user[0]->getRoles($object->role);
                        $user[0]->setPassword($object->password);
                        $user[0]->setIsVerified($object->is_verified);

                        $dbTool->insertData($user[0]);

                        $transaction->commit();

                        return $this->getResponse();
                    }
                    else{
                        $transaction->rollBack();

                        return $this->getResponse(null, 500);
                    }
                }
                catch (\Exception $e) {
                    print_r($e);
                    return $this->getResponse(null, 500);
                }
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
     * Endpoint dla admina który umożliwia usuwanie usera po jego id
     *
     * @Route("/admin/users/delete", name="user_delete", methods={"POST"})
     *
     * @SWG\Parameter(
     *     name="token_json",
     *     in="body",
     *     @Model(type=App\Query\GetUserDeleteQuery::class)
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

        $object = $this->getJsonData($request,'App\\Query\\GetUserDeleteQuery');

        list($allProvided, $missingAttributes) = $this->checkRrequiredDataFromQuery($object);

        if ($allProvided) {
            if ($this->authorizeToken($object->token, true)) {
                $entityManager = $this->getDoctrine();
                $dbTool = new DBTool($entityManager);
                $institution = $dbTool->findBy(Institution::class, ["name" => $_ENV['INSTITUTION_NAME']]);

                $user = $dbTool->findBy(User::class, ["isVerified" => 1, "user_id" => $object->id,"institution_id" =>$institution[0]->getId()]);
                try{
                    $em = $dbTool->getEntityManager();
                    $transaction = $em->getConnection();
                    $transaction->beginTransaction();
                    if($user[0]){
                        //TODO totu rozkmiń jak to zrobić bo nwm na razie
                        $userInfo = $dbTool->findBy(UserInfo::class, ["user_id" => $user[0]->getId()]);

                        if($userInfo[0])
                        {
                            $dbTool->removeData($userInfo[0],false);
                            $dbTool->removeData($user[0]);

                        }
//                        try{
//
//                            $userMylist = $dbTool->findBy(MyList::class, ["user_id" => $user[0]->getId()]);
//                            print_r($userMylist);
//                            if($userMylist[0])
//                            {
//                                $dbTool->removeData($userMylist[0]);
//                            }
//                            $userAudiobookInfo = $dbTool->findBy(AudiobookInfo::class, ["user_info_id" => $userInfo[0]->getId()]);
//                            if($userAudiobookInfo)
//                            {
//
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
                    else{
                        $transaction->rollBack();
                        return $this->getResponse(null, 500);
                    }
                }
                catch (\Exception $e) {
                    return $this->getResponse(null, 500);
                }
            }
            else{
                return $this->getResponse(null, 401);
            }
        }
        else{
            return $this->getResponse(null, 400);
        }
    }

}