<?php

namespace App\Controller;

use App\Entity\AdminUser;
use App\Entity\Token;
use App\Model\AdminAuthSuccessModel;
use App\Tools\DBTool;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;

/**
 * Class AdminController
 * @package App\Controller
 */
class AdminController extends MyController {
    /**
     * Endpoint login is used to generate new token for user given in request
     *
     * @Route("/admin/login", methods={"POST"})
     *
     * @SWG\Parameter(
     *     name="login_json",
     *     in="body",
     *     @Model(type=App\Query\AdminAuthQuery::class)
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Login data was correct. Login success.",
     *     @Model(type=App\Model\AdminAuthSuccessModel::class)
     * )
     *
     * @SWG\Response(
     *     response=401,
     *     description="Login data was empty or incorrect",
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
     * @return Response
     *
     */
    public function login(Request $request) : Response{
        //--------------------------------------------------------------------------------------------------------------
        // Getting Data and Parsing to Query
        //--------------------------------------------------------------------------------------------------------------
        $object = $this->getJsonData($request,'App\\Query\\AdminAuthQuery');
        //--------------------------------------------------------------------------------------------------------------


        //--------------------------------------------------------------------------------------------------------------
        // Checking the data if they are not empty
        //--------------------------------------------------------------------------------------------------------------
        list($allProvided, $missingAttributes) = $this->checkRrequiredDataFromQuery($object);
        //--------------------------------------------------------------------------------------------------------------

        if($allProvided){
            $dbTool = new DBTool($this->getDoctrine());
            //--------------------------------------------------------------------------------------------------------------
            // Searching for user with given login and password
            //--------------------------------------------------------------------------------------------------------------
            $params = [
                "login" => $object->login,
                "passwd" => md5($object->password)
            ];

            $users = $dbTool->findBySQL(AdminUser::class, "checkLogin", $params);

            //--------------------------------------------------------------------------------------------------------------
            if(count($users) > 0){
                $user = $users[0];

                $em = $dbTool->getEntityManager();

                $transaction = $em->getConnection();
                $transaction->beginTransaction();
                try{
                    //--------------------------------------------------------------------------------------------------------------
                    // Deactivating all active tokens
                    //--------------------------------------------------------------------------------------------------------------
                    $allTokens = $dbTool->findBy(Token::class, ["active" => 1, "admin_id" => $user->getUserId()]);

                    foreach ($allTokens as $oldToken){
                        $oldToken->setActive(false);

                        $dbTool->insertData($oldToken);
                    }
                    //--------------------------------------------------------------------------------------------------------------

                    //--------------------------------------------------------------------------------------------------------------
                    //  Generating a new token and adding it to the database. At the end we are returning this token in response
                    //--------------------------------------------------------------------------------------------------------------
                    $newGeneratedToken = openssl_random_pseudo_bytes(64);
                    $newGeneratedToken = bin2hex($newGeneratedToken);

                    $newToken = new Token($user,$newGeneratedToken);

                    $dbTool->insertData($newToken);

                    $transaction->commit();

                    $generatedTocken = new AdminAuthSuccessModel();

                    $generatedTocken->token = $newToken->getToken();

                    $generatedTocken = $this->makeJsonData($generatedTocken);

                    return $this->getResponse($generatedTocken);

                    //--------------------------------------------------------------------------------------------------------------

                }catch (\Exception $e){
                    $transaction->rollBack();

                    return $this->getResponse(null, 401);
                }
            }
            else{
                return $this->getResponse(null, 401);
            }
        }
        else{
            return $this->getResponse(null, 401);
        }
    }
    /**
     * Endpoint login is used to generate new token for user given in request
     *
     * @Route("/admin/logout", methods={"POST"})
     *
     * @SWG\Parameter(
     *     name="login_json",
     *     in="body",
     *     @Model(type=App\Query\GetSetsQuery::class)
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Login data was correct. logout success."
     * )
     *
     * @SWG\Response(
     *     response=401,
     *     description="Login data was empty or incorrect",
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
     * @return Response
     *
     */
    public function logoutAdmin(Request $request) : Response{
        $object = $this->getJsonData($request,'App\Query\GetSetsQuery');

        list($allProvided, $missingAttributes) = $this->checkRrequiredDataFromQuery($object);

        if ($allProvided) {
            if ($this->authorizeToken($object->token,true)){
                if($this->logout($object->token,true)){
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
