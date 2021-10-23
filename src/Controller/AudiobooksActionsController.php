<?php

namespace App\Controller;

use App\Engine\AudiobookEngine;
use App\Entity\Audiobook;
use App\Entity\Category;
use App\Entity\Institution;
use App\JsonModels\GetSetsAudiobooksJsonModel;
use App\JsonModels\GetSetsModel;
use App\Model\GetAudiobookModel;
use App\Model\GetSetsDataSuccessModel;
use App\Model\GetSetsSuccessModel;
use App\Query\GetAudiobookJsonQuery;
use App\Tools\AudiobooksActionsTool;
use App\Tools\DataTool;
use App\Tools\DBTool;
use App\Tools\FileBookManager;
use Exception;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use ZipArchive;

class AudiobooksActionsController extends MyController
{
    /**
     * Endpoint który służy do dodaia nowego audiobooka do serwera , jest w nim zawarta cała logika i zabezpieczenia
     * Wystarczy podać zipa z audiobookiem
     *
     * @Route("/audiobooks/addAudiobook", name="audiobooks_add", methods={"POST"})
     *
     * @SWG\Parameter(
     *     name="token_json",
     *     in="body",
     *     @Model(type=App\Query\AddAudiobookQuery::class)
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
     *z
     * @param Request $request
     *
     * @return Response
     */
    public function addAudiobook(Request $request): Response
    {
        $object = $this->getJsonData($request,'App\\Query\\AddAudiobookQuery');
        //--------------------------------------------------------------------------------------------------------------
        //At start its checks if in request all fields are provided and after that if we have access to any set
        //--------------------------------------------------------------------------------------------------------------
        list($allProvided, $missingAttributes) = $this->checkRrequiredDataFromQuery($object);

        if ($allProvided) {
            $audioTool = new AudiobooksActionsTool();
            $setName = $audioTool->getAccessSet($object->set_key);
            //----------------------------------------------------------------------------------------------------------
            if($setName)
            {
                //------------------------------------------------------------------------------------------------------
                //If yes we are checking if file exists. If not we are adding one
                //------------------------------------------------------------------------------------------------------
                if($audioTool->fileExists($object,$setName)){

                    $base64File = fopen($_ENV['MAIN_DIR'] ."/".$setName."/".$object->hash_name."/".$object->hash_name.$object->part_nr, "w");
                    fwrite($base64File,$object->base64);
                    fclose($base64File);
                    //move_uploaded_file($file, "/$object->set_name/$object->hash_name");
                }
                //------------------------------------------------------------------------------------------------------


                //------------------------------------------------------------------------------------------------------
                // After that we are trying to find out if this file is a last one by counting files and adding size of every file and comparing it to given in object
                //------------------------------------------------------------------------------------------------------
                if($audioTool->lastFile($object,$setName)){
                    //--------------------------------------------------------------------------------------------------

                    //--------------------------------------------------------------------------------------------------
                    //If its a last file we are attempting to combine them
                    //--------------------------------------------------------------------------------------------------
                    $fileName = $audioTool->combineFiles($object,$setName);
//                    $fileName = false;
                    //--------------------------------------------------------------------------------------------------

                    if($fileName)
                    {
                        //----------------------------------------------------------------------------------------------
                        //And after that unziping created file and at the end we  are creating json file with ID3 tags of tracks i newly added audiobook
                        //----------------------------------------------------------------------------------------------
                        $jsonData=$audioTool->unzip($object,$setName,$fileName);
                        $entityManager = $this->getDoctrine();
                        $dbTool = new DBTool($entityManager);

                        if($jsonData)
                        {
                            try {
                                $em = $dbTool->getEntityManager();
                                $transaction = $em->getConnection();
                                $transaction->beginTransaction();

                                $institution = $dbTool->findBy(Institution::class, ["name" => $_ENV['INSTITUTION_NAME']]);
                                $category = $dbTool->findBy(Category::class, ["name" => $setName,"institution_id" => $institution[0]->getId()]);
                                if($category)
                                {
                                    $audiobook = new Audiobook($category[0],$jsonData["title"],$jsonData["year"],$jsonData["publisher"],$jsonData["comments"],$jsonData["duration"],$jsonData["parts"]);
                                    $dbTool->insertData($audiobook);

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
                        //----------------------------------------------------------------------------------------------
                        else{
                            return $this->getResponse(null,500);
                        }
                    }
                    else
                    {
                        return $this->getResponse(null,500);
                    }
                }
                else{
                    return $this->getResponse();
                }
            }
            else{
                return $this->getResponse(null, 401);
            }
        }
        else {
            return $this->getResponse(null, 400);
        }
    }
    /**
     *  Endpoint który służy do tworzenia zipa z podanego audiobooka i zwraca ścieżkę do niego
     *
     * @Route("/audiobooks/getAudiobook", name="audiobooks_get", methods={"POST"})
     *
     * @SWG\Parameter(
     *     name="token_json",
     *     in="body",
     *     @Model(type=App\Query\GetAudiobookQuery::class)
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Everything was correct",
     *     @Model(type=App\Model\GetAudiobookModel::class)
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
    public function getZipFile(Request $request): Response
    {
        $object = $this->getJsonData($request, 'App\\Query\\GetAudiobookQuery');
        //--------------------------------------------------------------------------------------------------------------
        //At start its checks if in request all fields are provided and after that if we have access to any set
        //--------------------------------------------------------------------------------------------------------------
        list($allProvided, $missingAttributes) = $this->checkRrequiredDataFromQuery($object);

        if ($allProvided) {
            $audioTool = new AudiobooksActionsTool();
            $setName = $audioTool->getAccessSet($object->set_key);
            //----------------------------------------------------------------------------------------------------------
            if ($setName) {

                $mainDir = $_ENV['MAIN_DIR'] ."/";

                $folder = $mainDir.$setName."/".$object->book_set."/";

                $zipFile = $mainDir.$setName."/".$object->book_set.".zip";

                $zip = new ZipArchive;
                //--------------------------------------------------------------------------------------------------------------
                //Check if zip exists and if yes we are deleting it
                //--------------------------------------------------------------------------------------------------------------
                if(file_exists($zipFile)) {
                    unlink ($zipFile);
                }
                //--------------------------------------------------------------------------------------------------------------

                //--------------------------------------------------------------------------------------------------------------
                //This part is creating a zip file and it adds everything from indicated folder
                //--------------------------------------------------------------------------------------------------------------
                if($zip -> open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {

                    $dir = opendir($folder);

                    while($file = readdir($dir)) {
                        if(is_file($folder.$file)) {
                            $zip -> addFile($folder.$file, $object->book_set."/".basename($folder.$file));
                        }
                    }
                //--------------------------------------------------------------------------------------------------------------

                //--------------------------------------------------------------------------------------------------------------
                //And if zip can be closed and everything is ok respons is created
                //--------------------------------------------------------------------------------------------------------------
                    if($zip ->close()){
                        $res = new GetAudiobookModel();
                        $res->folder_dir=$zipFile;
                        $res = DataTool::makeJsonData($res);
                        return $this->getResponse($res);
                    }
                    else{
                        return $this->getResponse(null, 500);
                    }
                //--------------------------------------------------------------------------------------------------------------
                }
                else{
                    return $this->getResponse(null, 500);
                }
            }
            else{
                return $this->getResponse(null, 401);
            }
        }
        else {
            return $this->getResponse(null, 400);
        }
    }

    /**
     *  Endpoint który służy do wysyłania zipa do frontu
     *
     * \/home\/damian\/opt\/audiobooks\/thriller\/dsadsas_dsadsa.zip
     *
     * @Route("/audiobooks/sendZipFile", name="sendZipFile", methods={"POST"})
     *
     * @SWG\Parameter(
     *     name="token_json",
     *     in="body",
     *     @Model(type=App\Query\GetZipQuery::class)
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Everything was correct"
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
    public function sendZipFile(Request $request): Response
    {
        $object = $this->getJsonData($request, 'App\\Query\\GetZipQuery');
        //--------------------------------------------------------------------------------------------------------------
        //At start its checks if in request all fields are provided and after that if we have access to any set
        //--------------------------------------------------------------------------------------------------------------
        list($allProvided, $missingAttributes) = $this->checkRrequiredDataFromQuery($object);

        if ($allProvided) {
            //--------------------------------------------------------------------------------------------------------------
            //After checking we are creating a new respons with BinaryFileRespons and we are adding nessesary headers
            // and returning this new download response with zip file
            //--------------------------------------------------------------------------------------------------------------
            $response = new BinaryFileResponse($object->zip_dir);

            $response->headers->set('Content-Type', 'text/plain');
            $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:3000');
            $response->headers->set('Access-Control-Allow-Headers', 'origin, content-type, accept');
            $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, PUT, DELETE');
            $response->headers->set('Access-Control-Allow-Credentials', 'true');

            $response->setContentDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                basename($object->zip_dir)
            );
            $response->deleteFileAfterSend(true);
            return $response;
            //--------------------------------------------------------------------------------------------------------------
        }
        else {
            return $this->getResponse(null, 400);
        }
    }
    /**
     *
     *  Endpoint który służy do usuwania audiobooka o podanej nazwie
     *
     * @Route("/audiobooks/removeAudiobook", name="removeAudiobook", methods={"POST"})
     *
     * @SWG\Parameter(
     *     name="token_json",
     *     in="body",
     *     @Model(type=App\Query\DeleteAudiobookQuery::class)
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Everything was correct"
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
    public function removeAudiobook(Request $request): Response
    {
        $object = $this->getJsonData($request, 'App\\Query\\DeleteAudiobookQuery');
        //--------------------------------------------------------------------------------------------------------------
        //At start its checks if in request all fields are provided and after that if we have access to any set
        //--------------------------------------------------------------------------------------------------------------
        list($allProvided, $missingAttributes) = $this->checkRrequiredDataFromQuery($object);

        if ($allProvided) {
            $audioTool = new AudiobooksActionsTool();
            $setName = $audioTool->getAccessSet($object->set_key);
            if ($this->authorizeToken($object->token, true)) {
                $name=$object->name;
                try {
                    if ($setName) {
                    $audioEngine = new AudiobookEngine();

                        if($audioEngine->removeDir($setName."/".$name))
                        {
                            $doc = $this->getDoctrine();
                            $dbTool = new DBTool($doc);
                            $em = $dbTool->getEntityManager();
                            $transaction = $em->getConnection();
                            $transaction->beginTransaction();

                            try{
                            $audiobook = $dbTool->findBy(Audiobook::class, ["title" => $name]);
                            $dbTool->removeData($audiobook[0]);
                            $transaction->commit();
                            }

                            catch (\Exception $e) {
                            $transaction->rollBack();
                            return $this->getResponse(null, 500);
                            }
                            return $this->getResponse();
                        }
                        else{
                            return $this->getResponse(null, 500);
                        }
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
            }
        }
        else {
            return $this->getResponse(null, 400);
        }
    }
    /**
     *
     * Endpoint który służy do pobrania pliku jsona podanego audiobooka potrzebny przy edycji
     *
     * @Route("/audiobooks/getJsonAudiobook", name="getJsonAudiobook", methods={"POST"})
     *
     * @SWG\Parameter(
     *     name="token_json",
     *     in="body",
     *     @Model(type=App\Query\DeleteAudiobookQuery::class)
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Everything was correct"
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
    public function getJsonAudiobook(Request $request): Response
    {
        $object = $this->getJsonData($request,'App\\Query\\DeleteAudiobookQuery');

        list($allProvided, $missingAttributes) = $this->checkRrequiredDataFromQuery($object);

        if ($allProvided) {
            $audioTool = new AudiobooksActionsTool();
            $setName = $audioTool->getAccessSet($object->set_key);
            if ($this->authorizeToken($object->token, true)) {

                $audioEngine = new AudiobookEngine();
                try {
                    [$allFolders, $jsonFile] = $audioEngine->getDirFolders("/".$setName);
                    $fileManager = new FileBookManager();

                    if (!empty($jsonFile) != 0) {

                        $jsonData = $fileManager->readFile($_ENV['MAIN_DIR'] ."/".$setName."/".$object->name, $jsonFile);

                        if ($jsonData) {
                            $decodedJsonData = DataTool::getJsonData($jsonData, 'App\\JsonModels\\GetSetsAudiobooksJsonModel');
                            return $this->getResponse($this->makeJsonData($decodedJsonData));
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
            }
        }
        else {
            return $this->getResponse(null, 400);
        }
    }
    /**
     *
     * Endpoint który służy do edycji pliku json danego audibooka oraz zmiany jego danych w bazie
     *
     * @Route("/audiobooks/editAudiobook", name="editAudiobook", methods={"POST"})
     *
     * @SWG\Parameter(
     *     name="token_json",
     *     in="body",
     *     @Model(type=App\Query\GetSetsAudiobooksJsonQuery::class)
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Everything was correct"
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
    public function editAudiobook(Request $request): Response
    {
        $object = $this->getJsonData($request,'App\\Query\\GetSetsAudiobooksJsonQuery');

        list($allProvided, $missingAttributes) = $this->checkRrequiredDataFromQuery($object);

        if ($allProvided) {
            try {
                $audioTool = new AudiobooksActionsTool();
                $setName = $audioTool->getAccessSet($object->set_key);
                if($setName) {

                    $file = new FileBookManager();

                    $post_data = DataTool::makeJsonData(array(
                        "filename" => $object->filename,
                        "version" => $object->version,
                        "title" => $object->title,
                        "album" => $object->album,
                        "author" => $object->author,
                        "album_author" => $object->album_author,
                        "track" => $object->track,
                        "year" => $object->year,
                        "desc" => $object->desc,
                        "genre" => $object->genre,
                        "publisher" => $object->publisher,
                        "comments" => $object->comments,
                        "duration" => $object->duration,
                        "size" => $object->size,
                        "parts" => $object->parts
                    ));

                    $added = $file->writeObjectFile("meta+/!@Data.json", $setName . "/" . $object->name, $post_data, true);

                    if ($added) {
                    rename($_ENV['MAIN_DIR'] . "/".$setName . "/".$object->name, $_ENV['MAIN_DIR'] . "/".$setName . "/".$object->filename);

                        $entityManager = $this->getDoctrine();
                        $dbTool = new DBTool($entityManager);
                        try {
                            $em = $dbTool->getEntityManager();
                            $transaction = $em->getConnection();
                            $transaction->beginTransaction();

                            $institution = $dbTool->findBy(Institution::class, ["name" => $_ENV['INSTITUTION_NAME']]);
                            $category = $dbTool->findBy(Category::class, ["name" => $setName,"institution_id" => $institution[0]->getId()]);
                            if($category)
                            {
                                $audiobook = $dbTool->findBy(Audiobook::class, ["title" => $object->name,"category_id" => $category[0]->getId()]);
                                $audiobook[0]->setTitle($object->filename);
                                $audiobook[0]->setYear($object->year);
                                $audiobook[0]->setPublisher($object->publisher);
                                $audiobook[0]->setComments($object->comments);
                                $audiobook[0]->setDuration($object->duration);
                                $audiobook[0]->setParts($object->parts);

                                $dbTool->insertData($audiobook[0]);

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
                    } else {
                        return $this->getResponse(null, 500);
                    }
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
            return $this->getResponse(null, 400);
        }

    }

}
