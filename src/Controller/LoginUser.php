<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserToken;
use App\Model\AdminAuthSuccessModel;
use App\Tools\DBTool;
use App\Tools\UserActionsTool;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * Class LoginUser
 * @package App\Controller
 */
class LoginUser extends MyController{
    /**
     * Endpoint for downloading all sets and some data within them
     *
     * @Route("/user/login", name="user_login", methods={"POST"})
     *
     * @SWG\Parameter(
     *     name="token_json",
     *     in="body",
     *     @Model(type=App\Query\LoginUserQuery::class)
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
    public function loginUser(Request $request): Response{

        $object = $this->getJsonData($request,'App\Query\LoginUserQuery');

        list($allProvided, $missingAttributes) = $this->checkRrequiredDataFromQuery($object);

        if ($allProvided) {
            $entityManager = $this->getDoctrine();
            $dbTool = new DBTool($entityManager);

            $email=$object->email;
            $password=$object->password;
            $params = [
                "email" => $email,
                "password" => $password
            ];
            try {


                $user = $dbTool->findBySQL(User::class, "loginUser", $params);

                if ($user[0]) {
                    $em = $dbTool->getEntityManager();

                    $transaction = $em->getConnection();
                    $transaction->beginTransaction();
                    try {
                        $allTokens = $dbTool->findBy(UserToken::class, ["active" => 1, "user_id" => $user[0]->getId()]);

                        foreach ($allTokens as $oldToken) {
                            $oldToken->setActive(false);

                            $dbTool->insertData($oldToken);
                        }

                        $newGeneratedToken = openssl_random_pseudo_bytes(64);
                        $newGeneratedToken = bin2hex($newGeneratedToken);

                        $newToken = new UserToken($user[0], $newGeneratedToken);

                        $dbTool->insertData($newToken);

                        $transaction->commit();

                        $generatedTocken = new AdminAuthSuccessModel();

                        $generatedTocken->token = $newToken->getToken();

                        $generatedTocken = $this->makeJsonData($generatedTocken);

                        return $this->getResponse($generatedTocken);

                        //--------------------------------------------------------------------------------------------------------------

                    } catch (\Exception $e) {
                        $transaction->rollBack();
                        print_r($e);
                        return $this->getResponse(null, 401);
                    }
                } else {
                    return $this->getResponse(null, 401);
                }
            }
            catch (\Exception $e) {
                return $this->getResponse(null, 401);
            }
        }
        else {
            return $this->getResponse(null, 400);
        }
    }
    /**
     * Endpoint for downloading all sets and some data within them
     *
     * @Route("/user/logout", name="user_logout", methods={"POST"})
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
    public function logoutUser(Request $request): Response{
        $object = $this->getJsonData($request,'App\Query\GetSetsQuery');

        list($allProvided, $missingAttributes) = $this->checkRrequiredDataFromQuery($object);

        if ($allProvided) {
            if ($this->authorizeToken($object->token)){
                if($this->logout($object->token)){
                    return $this->getResponse();
                }
                else{
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