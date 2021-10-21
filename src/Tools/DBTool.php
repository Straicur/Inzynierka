<?php

namespace App\Tools;

use App\Entity\AdminUser;

/**
 * Class DBTool
 * @package App\Tools
 */
class DBTool{

    private $doctrine;
    private $em;

    /**
     * DBTool constructor.
     *
     * @param $doctrine
     */
    public function __construct($doctrine){
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getManager();
    }

    public function getEntityManager(){
        return $this->em;
    }

    /**
     * A method that persist the given element in the database and you dont have to flush but default is true
     *
     * @param $repository
     *
     * @param bool $flush
     */
    public function insertData($repository, bool $flush = true):void{
        $this->em->persist($repository);

        if($flush){
            $this->em->flush();
        }
    }

    /**
     * A method that removes the given element from the database and you dont have to flush but default is true
     *
     * @param $repository
     *
     * @param bool $flush
     */
    public function removeData($repository, bool $flush = true):void{
        $this->em->remove($repository);

        if($flush){
            $this->em->flush();
        }
    }

    /**
     * The method which retrieves the repository(where to find something) and params to specify target , limit to limit the output and startRow for offset
     *
     * @param $repository
     *
     * @param array $params
     *
     * @param int|null $limit
     *
     * @param int|null $startRow
     *
     * @return array[Objects]
     */
    public function findBy($repository,array $params, int $limit = null, int $startRow = null){
        $result = $this->doctrine->getRepository($repository)
                        ->findBy($params,null,$limit,$startRow);

        return $result;
    }

    /**
     * The method which retrieves the contents of the given nameQuery in given repository and params to specify target , limit to limit the output and startRow for offset
     *
     * @param $repository
     *
     * @param string $nameQuery
     *
     * @param array $params
     *
     * @param int|null $limit
     *
     * @param int|null $startRow
     *
     * @return array[Objects]
     *
     */
    public function findBySQL($repository, string $nameQuery, array $params, int $limit = null, int $startRow = null){
        $result = $this->doctrine->getRepository($repository)
            ->createNamedQuery($nameQuery)
            ->setParameters($params);

        if($startRow != null && $limit != null){
            $result = $result->setFirstResult(($startRow-1)*$limit);
        }

        if($limit != null){
            $result = $result->setMaxResults($limit);
        }

        $end = $result->getResult();

        return $end;
    }

}
