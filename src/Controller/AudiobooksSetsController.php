<?php

namespace App\Controller;

use App\Engine\AudiobookEngine;
use App\Entity\Category;
use App\Entity\Institution;
use App\JsonModels\GetSetsAudiobooksJsonModel;
use App\JsonModels\GetSetsAudiobooksModel;
use App\JsonModels\GetSetsModel;
use App\Model\GetSetsDataSuccessModel;
use App\Model\GetSetsSuccessModel;
use App\Tools\AudiobooksActionsTool;
use App\Tools\DataTool;
use App\Tools\DBTool;
use App\Tools\FileBookManager;
use Exception;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;

class AudiobooksSetsController extends MyController
{
    /**
     * Endpoint który służy do pobierania wszystkich setów i ich dancyh
     *
     * @Route("/audiobooks/getSets", name="audiobooks_gets", methods={"POST"})
     *
     * @SWG\Parameter(
     *     name="token_json",
     *     in="body",
     *     @Model(type=App\Query\GetSetsQuery::class)
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Token was correct",
     *     @Model(type=App\Model\GetSetsSuccessModel::class)
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
    public function getSets(Request $request): Response
    {
        $object = $this->getJsonData($request,'App\\Query\\GetSetsQuery');

        list($allProvided, $missingAttributes) = $this->checkRrequiredDataFromQuery($object);

        if ($allProvided) {
            if($this->authorizeToken($object->token, true)){

                $audioEngine = new AudiobookEngine();

                [$allFolders, $jsonFile] = $audioEngine->getDirFolders("");


                if (count($allFolders) != 0) {
                    try {
                        $fileManager = new FileBookManager();

                        foreach ($allFolders as $folder) {
                            $accessToken = "";
                            $name="";
                            $folderDir = '/' . $folder;

                            list($results, $json) = $audioEngine->getDirFolders($folderDir);

                            if (!empty($json) != 0) {
                                $jsonData = $fileManager->readFile($_ENV['MAIN_DIR']. $folderDir, $json);

                                if($jsonData){
                                    $jsonData = DataTool::getJsonData($jsonData, 'App\\JsonModels\\GetSetsJsonModel');


                                    if($jsonData->access_token&&$jsonData->name){
                                        $accessToken = $jsonData->access_token;
                                        $name = $jsonData->name;
                                    }
                                }
                            }
                            $preparedData[] = new GetSetsModel($name, $accessToken, $_ENV['MAIN_DIR'] . $folderDir, count($results));
                        }

                        $res = new GetSetsSuccessModel($preparedData);

                        $res = DataTool::makeJsonData($res);

                        return $this->getResponse($res);

                    } catch (Exception $e) {
                        print_r($e->getMessage());
                        return $this->getResponse(null, 500);
                    }
                }
                else {
                    return $this->getResponse($this->makeJsonData(new GetSetsSuccessModel()));
                }
            } else {
                return $this->getResponse(null, 401);
            }
        }
        else {
            return $this->getResponse(null, 400);
        }
    }

    /**
     *
     * Endpoint który służy do dodawania setów wraz z plikiem json
     *
     *
     * Data format
     * Name is an directory to our new set catalog
     * {
     *  "token": "53a3acad95ef46f7f1108063cc5839c3f2d65584c129bb604f741f598ece1323eb826e3c8873a8d2153458e0e063ea012b5a46eb6cad40b102ecb5008fe1aadb",
     *  "name": "criminal"
     * }
     *
     * @Route("/audiobooks/addSet", name="add_audiobook_sets", methods={"POST"})
     *
     * @SWG\Parameter(
     *     name="token_json",
     *     in="body",
     *     @Model(type=App\Query\AddSetsQuery::class)
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Everything correct. New set added"
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
    public function addNewSet(Request $request): Response
    {
        $object = $this->getJsonData($request,'App\\Query\\AddSetsQuery');

        list($allProvided, $missingAttributes) = $this->checkRrequiredDataFromQuery($object);
        //--------------------------------------------------------------------------------------------------------------
        //Checking if request has everything
        //--------------------------------------------------------------------------------------------------------------
        if ($allProvided) {
            if($this->authorizeToken($object->token, true)){
                //--------------------------------------------------------------------------------------------------------------
                //And we are trying to create new set for audiobooks
                //--------------------------------------------------------------------------------------------------------------
                try{

                    $audioEngine = new AudiobookEngine();

                    $newGeneratedToken = openssl_random_pseudo_bytes(16);
                    $newGeneratedToken = bin2hex($newGeneratedToken);

                    $added = $audioEngine->newSet($newGeneratedToken, $object->name);

                    if($added){
                        $entityManager = $this->getDoctrine();
                        $dbTool = new DBTool($entityManager);
                        try {
                            $em = $dbTool->getEntityManager();
                            $transaction = $em->getConnection();
                            $transaction->beginTransaction();

                            $institution = $dbTool->findBy(Institution::class, ["name" => $_ENV['INSTITUTION_NAME']]);


                            if($institution)
                            {
                                $category = new Category();
                                $category->setName($object->name);
                                $category->setInstitution_id($institution[0]);
                                $dbTool->insertData($category);

                                $transaction->commit();
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
                        return $this->getResponse();

                    }
                    else{
                        return $this->getResponse(null, 401);
                    }
                }
                catch (Exception $e) {
                    print_r($e->getMessage());
                    return $this->getResponse(null, 500);
                }
                //--------------------------------------------------------------------------------------------------------------
            }
            else {
                return $this->getResponse(null, 401);
            }
        }
        else {
            return $this->getResponse(null, 400);
        }
    }

    /**
     *
     * Endpoint który służy do pobierania danych pojedynczego setu po podaniu jego tokenu
     *
     * @Route("/audiobooks/getSetData", name="get_sets_data", methods={"POST"})
     *
     * @SWG\Parameter(
     *     name="token_json",
     *     in="body",
     *     @Model(type=App\Query\GetSetDataQuery::class)
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Correct token. Those are aviable books.",
     *     @Model(type=App\Model\GetSetsDataSuccessModel::class)
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
     * @return Response
     */
    public function getSetData(Request $request): Response
    {
        $object = $this->getJsonData($request,'App\\Query\\GetSetDataQuery');
        //--------------------------------------------------------------------------------------------------------------
        //Checking if request has everything
        //--------------------------------------------------------------------------------------------------------------
        list($allProvided, $missingAttributes) = $this->checkRrequiredDataFromQuery($object);

        if ($allProvided) {

            //--------------------------------------------------------------------------------------------------------------

            //--------------------------------------------------------------------------------------------------------------
            // Now we are trying to find any folder in Main dir
            //--------------------------------------------------------------------------------------------------------------
            $accessToken = $object->token;

            $audioEngine = new AudiobookEngine();

            [$allFolders, $jsonFile] = $audioEngine->getDirFolders("");


            //--------------------------------------------------------------------------------------------------------------

            //--------------------------------------------------------------------------------------------------------------
            // If there are any folders we are iterating over them and checking if and of those folders has a given token
            //--------------------------------------------------------------------------------------------------------------

            if (count($allFolders) != 0) {
                try{
                    $fileManager = new FileBookManager();
                    $preparedData=[];
                    foreach ($allFolders as $folder) {
                        $name="";
                        $size="";
                        $duration="";
                        $folderDir = '/' . $folder;
                        //--------------------------------------------------------------------------------------------------------------
                        list($results, $json) = $audioEngine->getDirFolders($folderDir);
                        //--------------------------------------------------------------------------------------------------------------`
                        //--------------------------------------------------------------------------------------------------------------
                        if (!empty($json) != 0) {
                            $jsonData = $fileManager->readFile($_ENV['MAIN_DIR']. $folderDir, $json);


                            if($jsonData){
                                $decodedJsonData = DataTool::getJsonData($jsonData, 'App\\JsonModels\\GetSetsJsonModel');
                                if($decodedJsonData->access_token){
                                    if($accessToken==$decodedJsonData->access_token){
                                        //TODO jakoś rozwiąż ten problem z serializacją
//
                                        foreach ($results as $result)
                                        {
                                            $jsonF = $fileManager->readFile($_ENV['MAIN_DIR']. $folderDir."/".$result, $json);
                                            $decodedJson = DataTool::getJsonData($jsonF, 'App\\JsonModels\\GetSetsAudiobooksJsonModel');
                                            $preparedData[] = new GetSetsAudiobooksModel($decodedJson->title,$decodedJson->size,$decodedJson->duration);

                                        }
//                                        $preparedDate  = new GetSetsDataSuccessModel($decodedJsonData);

                                        break;
                                    }
                                }
                            }
                        }
                    }
                    //--------------------------------------------------------------------------------------------------------------

// TODO Tu sam nwm jak to naprawić więc niech na razie będzie tak
//                    $res = new GetSetsDataSuccessModel($preparedData);

                    $res = DataTool::makeJsonData($preparedData);
                    return $this->getResponse($res);

                } catch (Exception $e) {
                    print_r($e->getMessage());
                    return $this->getResponse(null, 500);
                }
            }
            else{
                return $this->getResponse(DataTool::makeJsonData(new GetSetsDataSuccessModel([])), 200);
            }

        }
        else{
            return $this->getResponse(null, 400);
        }
        //--------------------------------------------------------------------------------------------------------------
    }
    /**
         *
         * Endpoint który służy do zmiany nazwy Setu oraz zmiany pliku json
         *
         * @Route("/audiobooks/changeSetName", name="change_set_name", methods={"POST"})
         *
         * @SWG\Parameter(
         *     name="token_json",
         *     in="body",
         *     @Model(type=App\Query\GetSetsJsonQuery::class)
         * )
         *
         * @SWG\Response(
         *     response=200,
         *     description="Everything was correct",
         * )
         *
         * @SWG\Response(
         *     response=400,
         *     description="Server could not understand the request due to invalid syntax"
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
        public function changeSetName(Request $request): Response
        {
            $object = $this->getJsonData($request,'App\\Query\\GetSetsJsonQuery');

            list($allProvided, $missingAttributes) = $this->checkRrequiredDataFromQuery($object);

            if ($allProvided && $object->new_name !== $object->old_name) {
                if($this->authorizeToken($object->login_token, true)) {
                    try {
                        $file = new FileBookManager();

                        $setToken=$object->set_token;
                        $newName=$object->new_name;
                        $oldName=$object->old_name;

                        $post_data = DataTool::makeJsonData(array('access_token' => $setToken,'name'=>$newName));

                        $added = $file->writeObjectFile("meta+/!@Data.json",$oldName,$post_data,true);

                        if($added){
                            rename($_ENV['MAIN_DIR']."/".$oldName, $_ENV['MAIN_DIR']."/".$newName);
                            $entityManager = $this->getDoctrine();
                            $dbTool = new DBTool($entityManager);
                            try {
                                $em = $dbTool->getEntityManager();
                                $transaction = $em->getConnection();
                                $transaction->beginTransaction();

                                $institution = $dbTool->findBy(Institution::class, ["name" => $_ENV['INSTITUTION_NAME']]);
                                $category = $dbTool->findBy(Category::class, ["institution_id" => $institution[0]->getId(),"name" => $oldName]);

                                if($category)
                                {
                                    $category[0]->setName($object->new_name);
                                    $dbTool->insertData($category[0]);

                                    $transaction->commit();
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
                            return $this->getResponse();
                        }
                        else{
                            return $this->getResponse(null, 500);
                        }
                    }
                    catch (Exception $e) {
                        print_r($e->getMessage());
                        return $this->getResponse(null, 500);
                    }
                }
                else {
                    return $this->getResponse(null, 401);
                    // Nieautoryzowany lub istnieje już taka nazwa
                }
            }
            else {
                return $this->getResponse(null, 400);
            }
        }

    /**
     *
     * Endpoint który służy do usuwania podanego setu po podaniu jego nazwy i tokenu
     *
     * @Route("/audiobooks/deleteSet", name="delete_set", methods={"POST"})
     *
     * @SWG\Parameter(
     *     name="token_json",
     *     in="body",
     *     @Model(type=App\Query\GetDeleteSetQuery::class)
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Everything was correct",
     * )
     *
     * @SWG\Response(
     *     response=400,
     *     description="Server could not understand the request due to invalid syntax"
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
    public function deleteSet(Request $request): Response
    {
        $object = $this->getJsonData($request, 'App\\Query\\GetDeleteSetQuery');

        list($allProvided, $missingAttributes) = $this->checkRrequiredDataFromQuery($object);

        if ($allProvided) {
            if ($this->authorizeToken($object->login_token, true)) {
                $name=$object->name;
                try {
                    $fileManager = new FileBookManager();
                    $jsonData = $fileManager->readFile($_ENV['MAIN_DIR']."/". $name, "metaData.json");
                    if($jsonData){
                        $decodedJsonData = DataTool::getJsonData($jsonData, 'App\\JsonModels\\GetSetsJsonModel');
                        if($decodedJsonData->access_token){
                            if($object->set_token==$decodedJsonData->access_token){
                                $audioEngine = new AudiobookEngine();
                                if($audioEngine->removeDir($name))
                                {
                                    $entityManager = $this->getDoctrine();
                                    $dbTool = new DBTool($entityManager);
                                    try {
                                        $em = $dbTool->getEntityManager();
                                        $transaction = $em->getConnection();
                                        $transaction->beginTransaction();

                                        $institution = $dbTool->findBy(Institution::class, ["name" => $_ENV['INSTITUTION_NAME']]);
                                        $category = $dbTool->findBy(Category::class, ["institution_id" => $institution[0]->getId(),"name" => $name]);

                                        if($category)
                                        {
                                            $dbTool->removeData($category[0]);

                                            $transaction->commit();
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
                                    return $this->getResponse();
                                }
                                else{
                                    return $this->getResponse(null, 500);
                                }
                            }
                            else {
                                return $this->getResponse(null, 401);
                            }
                        }
                        else {
                            return $this->getResponse(null, 500);
                        }
                    }
                    else {
                        return $this->getResponse(null, 500);
                    }
                }
                catch (Exception $e) {
                        print_r($e->getMessage());
                        return $this->getResponse(null, 500);
                }
            }
            else {
                return $this->getResponse(null, 401);
            }
        }
        else {
            return $this->getResponse(null, 400);
        }
    }

}
