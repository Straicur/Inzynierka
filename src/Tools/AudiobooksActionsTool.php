<?php

namespace App\Tools;

use App\Engine\AudiobookEngine;
use App\Entity\AdminPassword;
use App\Entity\AdminUser;
use FilesystemIterator;
use JMS\Serializer\SerializerBuilder;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Symfony\Component\Filesystem\Filesystem;
use ZipArchive;


/**
 * Class AudiobooksActionsTool
 *
 * @package App\Tools
 */
class AudiobooksActionsTool
{
    /**
     * This method is trying to find catalog and if its not here it will creat one and true is returned
     * if there is on its checking if file exists if yes false is returned
     *
     * @param $object
     *
     * @param $setName
     *
     * @return bool
     */
    public function fileExists($object,$setName): bool
    {
        $fsObject = new Filesystem();

        $whole_dir_path= $_ENV['MAIN_DIR']."/".$setName."/".$object->hash_name;

        $file=$whole_dir_path."/".$object->hash_name.$object->part_nr;

        if(!$fsObject->exists($whole_dir_path))
        {
            $old = umask(0);
            $fsObject->mkdir($whole_dir_path, 0775);
            umask($old);
        }

        if(!$fsObject->exists($file))
        {
            return true;
        }
        elseif($fsObject->exists($file)){
            return false;
        }
        else{
            return false;
        }
    }
    /**
     * This method is checking if given file is a lastone , it will check if file sizes of all files is equal to given in object
     * and will iterate over files to check if amount of them is equal to given in object and if yes return true
     *
     * @param $object
     *
     * @param $setName
     *
     * @return bool
     */
    public function lastFile($object,$setName): bool{
        $whole_dir_path= $_ENV['MAIN_DIR']."/".$setName."/".$object->hash_name;

        $amountOfFiles = 0;

        if ($handle = opendir($whole_dir_path)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    $amountOfFiles += 1;
                }
            }
            closedir($handle);
        }

        if($amountOfFiles == $object->all_parts_nr){
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * this method is trying to combine all given file parts into one zip
     * it will iterate over every file in given directory and setName and will write base64 to zip file
     * after that it will delete catalog where all parts are stored
     *
     * @param $object
     *
     * @param $setName
     *
     * @return false|string
     */
    public function combineFiles($object,$setName)
    {
        try {
            $path = $_ENV['MAIN_DIR'] . "/" .$setName. "/" . $object->hash_name;
            $finalFile = $_ENV['MAIN_DIR'] . "/" .$setName. "/" .$object->file_name.".zip";

            $zipFile = fopen($finalFile,"a");

            $files = array_diff(scandir($path), array('.', '..'));
            $result = [];
            foreach ($files as $file) {
                $hash=strlen($object->hash_name);
                array_push($result,substr($file, $hash));
            }
            sort($result);

            foreach ($result as $file) {

                $partFile = fopen( $_ENV['MAIN_DIR'] . "/" .$setName. "/" . $object->hash_name."/".$object->hash_name.$file,"r");

                $readData = fread($partFile,filesize($_ENV['MAIN_DIR'] . "/" .$setName. "/" . $object->hash_name."/".$object->hash_name.$file));

                fwrite($zipFile,base64_decode($readData,true));

                fclose($partFile);

            }

            fclose($zipFile);

            $it = new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS);
            $files = new RecursiveIteratorIterator($it,
                RecursiveIteratorIterator::CHILD_FIRST);
            foreach ($files as $file) {
                if ($file->isDir()) {
                    rmdir($file->getRealPath());
                } else {
                    unlink($file->getRealPath());
                }
            }

            if (rmdir($path)) {
                return $finalFile;
            } else {
                return false;
            }
        }
        catch (\Exception $e){
            print_r($e);
            return false;
        }
    }

    /**
     * this method is creating a json file with data from ID3 tags of mp3 file in new unziped audiobook
     *
     * @param $object
     *
     * @param $setName
     */
    public function createAudiobookJsonData($object,$setName):void
    {
        $mp3file = "";
        $id3Tags = new AudiobooksID3TagsReader();
        $id3Data = [];
        $mp3Size=0;
        $mp3Duration=0;
        if ($handle = opendir($_ENV['MAIN_DIR'] . "/" . $setName . "/" . $object->file_name)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    $file_parts = pathinfo($entry);
                    if ($file_parts['extension'] == "mp3") {
                        $mp3file = $entry;
                        if ($mp3file !== "") {
                            $mp3Dir = $_ENV['MAIN_DIR'] . "/" . $setName . "/" . $object->file_name . "/" . $mp3file;
                            $mp3FileDuration = new MP3FileTool($mp3Dir);
                            //TODO tu też musze dodać tą ilość partów w folderach i rozszerz wtedy query pobierające to z jsona odrazu
                            $mp3Duration = $mp3Duration + $mp3FileDuration->getDuration();

                            $mp3Size = $mp3Size + filesize($mp3Dir);

                            $id3TrackData = $id3Tags->getTagsInfo($mp3Dir);

                            if (empty($id3Data)) {
                                foreach ($id3TrackData as $key => $index) {
                                    $id3Data[$key] = $index;
                                }
                            } else {
                                $sameKeys = array_intersect_key($id3Data, $id3TrackData);
                                $keys = array_keys($id3TrackData);
                                foreach ($keys as $key => $index) {
                                    if (array_key_exists($key, $sameKeys)) {
                                        continue;
                                    } else {
                                        $id3Data[$index] = $id3TrackData[$index];
                                    }
                                }
                            }
                        }
                    }
                }
            }
            closedir($handle);
        }

        $id3Data['duration'] = MP3FileTool::formatTime($mp3Duration);
        $id3Data['size'] = number_format($mp3Size / 1048576, 2);

        if(empty($id3Data)){
            $post_data = DataTool::makeJsonData(array('Problem' => "Nie może znależć danych"));
        }
        else{
            $post_data = DataTool::makeJsonData($id3Data);
        }
        $file = new FileBookManager();
        //TODO tu dajesz to w ifie i jak będzie że zwróci true to dodajemy do bazy te dane i tu mam już wtedy wszystkie audiobooki w bazie dzięki temu
        $file->writeObjectFile("meta+/!@Data.json",$setName."/".$object->file_name,$post_data,true);
    }

    /**
     * this method is unziping a zip created before and after that the json with data of mp3 file is created
     *
     * @param $object
     *
     * @param $setName
     *
     * @param $fileName
     *
     * @return bool
     */
    public function unzip($object,$setName,$fileName): bool
    {
        $file = $_ENV['MAIN_DIR']."/".$setName."/".$object->file_name.".zip";
        $path = $_ENV['MAIN_DIR']."/".$setName;

        $zip = new ZipArchive;
        $res = $zip->open($fileName);

        if ($res === TRUE) {

            $dir = trim($zip->getNameIndex(0), '/');

            $zip->extractTo($path);
            $zip->close();
            unlink($file);

            rename($_ENV['MAIN_DIR']."/".$setName."/".$dir, $_ENV['MAIN_DIR']."/".$setName."/".$object->file_name);



            $this->createAudiobookJsonData($object,$setName);

            return true;
        }
        else{
            return false;
        }
    }

    /**
     * This method is returning name of set where we have access with given token
     *
     * @param $token
     *
     * @return false|string
     */
    public function getAccessSet($token){
        $audioEngine = new AudiobookEngine();

        [$allFolders, $jsonFile] = $audioEngine->getDirFolders("");

        $accessedSet="";

        if (count($allFolders) != 0) {

            $fileManager = new FileBookManager();

            foreach ($allFolders as $folder) {
                $folderDir = '/' . $folder;

                list($results, $json) = $audioEngine->getDirFolders($folderDir);

                if (!empty($json) != 0) {
                    $jsonData = $fileManager->readFile($_ENV['MAIN_DIR'] . $folderDir, $json);
                    if ($jsonData) {
                        $decodedJsonData = DataTool::getJsonData($jsonData, 'App\\JsonModels\\GetSetsJsonModel');
                        if ($decodedJsonData->access_token) {
                            if ($token === $decodedJsonData->access_token) {
                                $accessedSet = $decodedJsonData->name;

                                break;
                            }
                        }
                    }
                }
            }
            if(empty($accessedSet)){
                return false;
            }
            else{
                return $accessedSet;
            }
        }
        else {
            return false;
        }
    }

    /**
     *
     */
    public function getAudiobookJson(String $token,String $dir=""){
        $audioEngine = new AudiobookEngine();

        [$allFolders, $jsonFile] = $audioEngine->getDirFolders($dir);
        $fileManager = new FileBookManager();
        $accessedSet="";

        if (!empty($json) != 0) {
            $jsonData = $fileManager->readFile($_ENV['MAIN_DIR'] . $dir, $jsonFile);
            if ($jsonData) {
                $decodedJsonData = DataTool::getJsonData($jsonData, 'App\\JsonModels\\GetSetsAudiobooksJsonModel');
                if ($decodedJsonData->access_token) {
                    if ($token === $decodedJsonData->access_token) {
                        $accessedSet = $decodedJsonData->name;
                    }
                }
            }
        }

        if(empty($accessedSet)){
            return false;
        }
        else{
            return $accessedSet;
        }

    }
}