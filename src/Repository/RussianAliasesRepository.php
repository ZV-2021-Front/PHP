<?php

namespace App\Repository;

use App\Entity\RussianAliases;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use Doctrine\DBAL\Connection;

/**
 * @method RussianAliases[]    getAliases($fields)
 */
class RussianAliasesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RussianAliases::class);
    }

   /**
     * @return RussianAliases[] Returns an array of RussianAliases objects
     */
    public function getAliases($fields, string $table_name = null, string $data_base = null )
    {
        $queryBuilder = $this->createQueryBuilder('ra');

        $queryBuilder->select("ra.field", "ra.russian_aliases");

        $queryBuilder->andWhere("ra.field IN (:fields)")->setParameter('fields', $fields, Connection::PARAM_STR_ARRAY);

        if (isset($table_name)) 
            $queryBuilder->andWhere("ra.table_name = (:table_name)")->setParameter('table_name', $table_name);
        if (isset($data_base)) 
            $queryBuilder->andWhere("ra.data_base = (:data_base)")->setParameter('data_base', $data_base);

        return $queryBuilder->getQuery()->getResult();
        
    }
}
