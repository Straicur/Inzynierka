<?php
namespace App\Tools;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;
use JMS\Serializer\SerializerBuilder as Serializer;

class  FileBookManager{

    /**
     *
     * metoda która czyta dane z plików jako string i zwraca go
     * USAGE LIKE
     * $fileread= $file->readFile("/home/damian/JsonData","dsadas.txt");
     *
     * @param String $dir_path
     *
     * @param String $name
     *
     * @return false|string|null
     */
    public function readFile(String $dir_path,String $name){

        $finder = new Finder();

        $file_parts = pathinfo($name);

        if(isset($file_parts['extension'])){
            if($name || empty($name)){

                $finder->files()->in($dir_path)
                    ->name($name)
                    ->depth(0);

                if ($finder->hasResults()){
                    $contents=null;
                    foreach ($finder as $file) {

                    $contents = $file->getContents();

                    }
                    return $contents;
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }

    /**
     *
     * metoda która zapisuje do pliku(w podanej ścieżce) tekstowego podany string
     *
     * @param String $dir_path
     *
     * @param String $name
     *
     * @param String $text
     *
     * @return bool
     */
    public function writeTextFile(String $dir_path,String $name, String $text): bool
    {

        $fsObject = new Filesystem();

        $file_parts = pathinfo($name);

        //--------------------------------------------------------------------------------------------------------------
        // Sprawdzenie czy pod podaną ścieżką isteniej  i jeśli nie to jest tworzony
        //--------------------------------------------------------------------------------------------------------------


        if (!$fsObject->exists($dir_path))
        {
            $old = umask(0);
            $fsObject->mkdir($dir_path, 0775);
            // $fsObject->chown($dir_path, 'www-data');//changes the owner of file
            // $fsObject->chgrp($dir_path, 'nginx');//changes the group of a file.
            umask($old);
        }

        //--------------------------------------------------------------------------------------------------------------


        //--------------------------------------------------------------------------------------------------------------
        // Sprawdzenie czy podany plik txt istnieje i jeśli nie to jest tworzony a jeśli tak to dane są nadpisywane
        //--------------------------------------------------------------------------------------------------------------

        if(isset($file_parts['extension'])){

            if($name || empty($name)){

                $dir_path=$dir_path.$name;

                if(!$fsObject->exists($dir_path))
                {
                    $fsObject->touch($dir_path );
                    $fsObject->chmod($dir_path , 0777);
                    $fsObject->dumpFile($dir_path , $text);
                    return true;
                }
                else{
                    $fsObject->dumpFile($dir_path , $text);
                    return true;
                }
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
        //--------------------------------------------------------------------------------------------------------------
    }

    /**
     * a method that write object($object) parameter to a file($name with extension) in $dir_path as a string
     * USAGE LIKE
     * $file -> writeObjectFile("d@s!#a+da s.txt","/JsonData/Data",$post_data);
     *
     * @param $name
     *
     * @param $dir_path
     *
     * @param $object
     *
     * @param bool $override
     *
     * @return bool
     */
    public function writeObjectFile($name, $dir_path, $object, bool $override = false): bool
    {

        $fsObject = new Filesystem();

        $checkedName = $this->checkNameChars($name);

        $whole_dir_path= $_ENV['MAIN_DIR']."/".$dir_path;

        $file_parts = pathinfo($checkedName);

        $jmsData=null;

        if($file_parts['extension']=="json"){
            $jmsData = $object;

        }
        else{
            //serializing json to string
            $serializer = Serializer::create()->build();
            $jmsData = $serializer->serialize($object, 'json');
        }

        //--------------------------------------------------------------------------------------------------------------
        // Sprawdzenie czy podana ścieżka istnieje i jeśli nie to jest tworzona a jeśli tak to dane są nadpisywane
        //--------------------------------------------------------------------------------------------------------------

        if(isset($file_parts['extension'])){
            if($checkedName || empty($checkedName)){

                $file=$whole_dir_path ."/". $checkedName;
                if (!$fsObject->exists($whole_dir_path))
                {

                    $old = umask(0);
                    $fsObject->mkdir($whole_dir_path, 0775);
                    umask($old);

                    $fsObject->touch($file);
                    $fsObject->chmod($file , 0777);
                    $fsObject->dumpFile($file , $jmsData);

                    return true;
                }
                elseif(($fsObject->exists($file) && $override) || !$fsObject->exists($file)){

                    $fsObject->dumpFile($file , $jmsData);

                    return true;
                }
                else{

                    return false;
                }
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }

        //--------------------------------------------------------------------------------------------------------------
    }

    /**
     * Metoda która sprawdza czy podana nazwa pliku jest poprawnie podana i usuwa wszystkie niepotrzebne znaki
     *
     * @param string $name
     *
     * @return string
     */
    public function checkNameChars(string $name):string
    {
        $checkedName = str_replace(' ', '_', $name);

        $checkedName = preg_replace('/[^A-Za-z0-9.\-]/', '', $checkedName);

        return $checkedName;
    }
}   
