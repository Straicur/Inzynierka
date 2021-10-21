<?php

namespace App\Engine;

use App\Tools\DataTool;
use App\Tools\FileBookManager;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Symfony\Component\Filesystem\Filesystem;


/**
 * Class AudiobookEngine
 *
 * @package App\Engine
 */
class AudiobookEngine{

    /**
     * This method is adding catalog if doesn't exist and adds/modifies a json file with token and name of this catalog
     *
     * @param $token
     *
     * @param $name
     *
     * @return bool
     */
    public function newSet($token, $name): bool
    {
        $file = new FileBookManager();

        $post_data = DataTool::makeJsonData(array('access_token' => $token,'name'=>$name));

        $added = $file->writeObjectFile("meta+/!@Data.json",$name,$post_data);

        return $added;
    }

    /**
     * This method is checking given direction for folders and json files
     * Return is an array with names of folders and name of json file if there is any
     *
     * @param $dir
     *
     * @return array
     *
     */
    public function getDirFolders($dir): array
    {
        $allFolders=array();
        $jsonFile="";
        if ($handle = opendir($_ENV['MAIN_DIR'].$dir)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    $file_parts = pathinfo($entry);
                    if(!isset($file_parts['extension'])){
                        $allFolders[] = $entry;
                    }
                    elseif($file_parts['extension']=="json" && $file_parts['filename']=="metaData"){
                        $jsonFile = $entry;
                    }
                    else{
                        continue;
                    }
                }
            }
            closedir($handle);
        }
        return [$allFolders,$jsonFile];
    }
        /**
         * This method is returning a json of set or audiobook
         *
         * On tu ma dostać tylko ścieche i z niej poszukać pliku json ale też sprawdza token w tym jsonie  i zwrócić go i tylke a reszta logiki w controlerze
         * @param String $token
         * @param string $dir
         * @return false|string
         */

        public function getSetsJson(String $token,String $dir=""){
            $audioEngine = new AudiobookEngine();

            [$allFolders, $jsonFile] = $audioEngine->getDirFolders("/".$dir);
            $fileManager = new FileBookManager();
            $accessedDataSet=null;

            if (!empty($jsonFile) != 0) {
                $jsonData = $fileManager->readFile($_ENV['MAIN_DIR'] ."/". $dir, $jsonFile);
                if ($jsonData) {
                    $decodedJsonData = DataTool::getJsonData($jsonData, 'App\\JsonModels\\GetSetsJsonModel');
                    if ($decodedJsonData->access_token) {
                        if ($token === $decodedJsonData->access_token) {
                            $accessedDataSet = $decodedJsonData;
                        }
                    }
                }
            }

            if(empty($accessedDataSet)){
                return false;
            }
            else{
                return $accessedDataSet;
            }

        }
        public function removeDir(String $name){
            $dir = $_ENV['MAIN_DIR']."/".$name;

            $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
            $files = new RecursiveIteratorIterator($it,
                RecursiveIteratorIterator::CHILD_FIRST);
            foreach($files as $file) {
                if ($file->isDir()){
                    rmdir($file->getRealPath());
                } else {
                    unlink($file->getRealPath());
                }
            }
            return rmdir($dir);
        }

}

