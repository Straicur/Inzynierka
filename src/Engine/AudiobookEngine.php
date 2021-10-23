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
     *
     * Metoda która tworzy nowy set jeśli nie nie istnieje i tworzy plik json dla niego a jeśli istnieje to modyfikuje plik json
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
     *
     * Metoda która zwraca tablicę z wszystkimi folderami w podanej ścieżce oraz pliku json danego setu
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
         *
         * Metoda która zwraca plik json danego setu
         *
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

