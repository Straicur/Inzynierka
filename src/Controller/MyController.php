<?php

namespace App\Controller;

use App\Annotations\DataRequired;
use App\Entity\Token;
use App\Entity\User;
use App\Entity\UserToken;
use App\Tools\DBTool;
use DateInterval;
use DateTime;
use Doctrine\Common\Annotations\AnnotationReader;
use ReflectionClass;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializerBuilder;

/**
 * Class MyController
 * @package App\Controller
 */
class MyController extends AbstractController{

    /**
     * getJsonData is deserializing $request to given Class($className) and returning it as a Json
     *
     * @param Request $request
     *
     * @param $className
     *
     * @return mixed
     */
    protected function getJsonData(Request $request, $className){
        $serializer = SerializerBuilder::create()->build();

        $serializedObject = $serializer->deserialize($request->getContent(),$className,'json');

        return $serializedObject;
    }

    /**
     * Method authorize as a parameter is taking a single Token and is checking if this token is active
     * If yes it will add 10 min to $active_to value and will return true
     * If not it will find all Tokens with flag activ set to 1 and change it to 0 and will return false
     *
     * @param $query
     * @param $admin
     * @return bool
     */
    protected function authorize($query,$admin): bool
    {
        $doctrine = $this->getDoctrine();

        $dbTool = new DBTool($doctrine);

        $active_to = new DateTime('NOW');

        if(!empty($query)){
            if($query->getActiveTo()>=$active_to && $query->getActive()) {
                $active_to = $active_to->add(new DateInterval('PT10M'));

                $query->setActiveTo($active_to);

                $dbTool->insertData($query);
                //Usuwanie niepotrzebnych tokenów przy każdej autoryzacji
                if($admin){
                    $allUnactiveTokens = $dbTool->findBySQL(Token::class,"unactive",[]);

                    foreach ($allUnactiveTokens as $token){
                        $dbTool->removeData($token);
                    }
                }
                else{
                    $allUnactiveTokens = $dbTool->findBySQL(UserToken::class,"unactive",[]);

                    foreach ($allUnactiveTokens as $token){
                        $dbTool->removeData($token);
                    }
                }

                return true;
            }
            else {
                if($admin){
                    $allTokens = $dbTool->findBySQL(Token::class,"active",[]);
                }
                else{
                    $allTokens = $dbTool->findBySQL(UserToken::class,"active",[]);
                }
                if(count($allTokens)>0){
                    foreach ($allTokens as $token){
                        $token->setActive(false);

                        $dbTool->insertData($token);
                    }
                }
                return false;
            }
        }
        else{
            return false;
        }
    }

    /**
     * @param $token
     * @param bool $admin
     * @return bool
     */
    protected  function logout($token,bool $admin=false): bool
    {
        $doctrine = $this->getDoctrine();
        $dbTool = new DBTool($doctrine);

        if($admin){
            $findedToken = $dbTool->findBy(Token::class,["token"=>$token],1);
        }

        else{
            $findedToken = $dbTool->findBy(UserToken::class,["token"=>$token],1);
        }
        if($findedToken){
            $findedToken[0]->setActive(false);

            $dbTool->insertData($findedToken[0]);
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * This method is trying to find given token in database and returning one if there is one
     *
     * @param $token
     * @param $admin
     * @return array|false
     */
    protected  function getauthorizeToken($token,$admin){
        $doctrine = $this->getDoctrine();
        $dbTool = new DBTool($doctrine);

        if($admin){
            $findedToken = $dbTool->findBy(Token::class,["token"=>$token],1);
        }

        else{
            $findedToken = $dbTool->findBy(UserToken::class,["token"=>$token],1);
        }
        if(!empty($findedToken)){
            return $findedToken;
        }
        else{
            return false;
        }
    }

    /**
     * This method is checking if There is any given token and if its authorized
     *
     * @param $token
     * @param bool $admin
     * @return bool
     */
    protected function authorizeToken($token, bool $admin=false): bool
    {
        $token = $this->getauthorizeToken($token,$admin);

        if(!$token){
            return false;
        }
        else{
            if ($this->authorize($token[0],$admin)) {
                return true;
            }
            else{
                return false;
            }
        }
    }

    /**
     * This Method is checking if query object properties are not null and not empty
     *
     * @param Object $query
     *
     * @return array
     *
     */
    protected function checkRrequiredDataFromQuery(Object $query): array
    {
        $result = true;
        $resultMissing = [];

        $reader = new AnnotationReader();

        $refClass = new ReflectionClass($query);
        $refPropertiesArray = $refClass->getProperties();

        foreach ($refPropertiesArray as $refProprety){
            $propertyAnnotations = $reader->getPropertyAnnotations($refProprety);

            foreach ($propertyAnnotations as $annotation){
                if($annotation instanceof DataRequired){
                    $propName = $refProprety->getName();

                    if($query->$propName == null || empty($query->$propName) || !isset($query->$propName)){
                        $result = false;
                        $resultMissing[] = $propName;
                    }
                }
            }
        }
        return [$result, $resultMissing];
    }

    /**
     * Method makeJsonData is used to serialize given model and its used later to Serialize Json Model to string in method getResponse
     *
     * @param $model
     *
     * @return string
     */
    protected function makeJsonData($model): string
    {
        $serializer = SerializerBuilder::create()->build();

        $serializedModel = $serializer->serialize($model, 'json');

        return $serializedModel;
    }

    /**
     * Method getResponse is returning new Response with encodedModel and statusCode
     *
     * @param string|null $encodedModel
     *
     * @param int $statusCode
     *
     * @return Response
     */
    protected function getResponse(string $encodedModel = null,int $statusCode = 200): Response
    {
        $response = new Response($encodedModel,$statusCode);

        $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:3000');
        $response->headers->set('Access-Control-Allow-Headers', 'origin, content-type, accept');
        $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, PUT, DELETE');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');

        return $response;
    }
}
