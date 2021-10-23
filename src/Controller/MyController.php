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
 *
 * Podstawowa Klasa Controllera z wszystkimi generycznymi metodami
 *
 * @package App\Controller
 */
class MyController extends AbstractController{

    /**
     * Metoda która deserializuje request z do podanej kalsy
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
     *
     * Metoda która sprawdza czy podany admin/użytkownik jest zalogowany poptrzez sprawdzenie znalezionego tokenu i sprawdznie
     * w bazie czy ma ustawioną flagę active na true i jeśli tak to wydłuża jego życie o dodatkowe 10 min oraz po czym usuwa nieaktywne
     * Oraz gdy podany token nie jest aktywny to dezaktywuje wszystkie tokeny tego admina/użytkownika
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
                $id = $query->getUserId();
                if($admin){
                    $allTokens = $dbTool->findBySQL(Token::class,"active",["admin_id"=>$id]);
                }
                else{
                    $allTokens = $dbTool->findBySQL(UserToken::class,"active",["user_id"=>$id]);
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
     * Metoda która szuka podanego tokenu w bazie i jeśli istnieje to zwraca go
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
     * Metoda która sprawdza czy podany token istnieje i jeśli tak to sprawdza czy jest aktywny
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
     *
     * Metoda która służy do dezaktywacji podanego tokenu
     *
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
     *
     * Metoda która sprawdza czy wszystkie zmienne objektu query zostałe zawarte i nie są puste
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
     * Metoda która serializyje podany model do jsona
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
     * Metoda tworząca nowy request z ustawionymi headerami
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
