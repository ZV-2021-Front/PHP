<?php

namespace App\Repository;

use App\Entity\Apples;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;

/**
 * @method Apples[]    fetchRow($xAxisField, $yAxisField, $products, $date)
 */
class ApplesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Apples::class);
    }

    /**
     * @return Apples[] Returns an array of Apples objects
     */
    public function fetchRow($xAxisField, $yAxisField, $products, $date)
    {
        $queryBuilder = $this->createQueryBuilder('a');

        $queryBuilder->select("a.{$xAxisField}", "a.{$yAxisField}");
        
        if($products[0] != 'all' )
            $queryBuilder->andWhere("a.products IN (:products)")->setParameter('products', $products, Connection::PARAM_STR_ARRAY);
            
        
            if(count($date) == 1){
                $queryBuilder->andWhere("a.date = (:date)")->setParameter('date', $date);
            }else{
                $queryBuilder->andWhere("a.date BETWEEN  :date_1 AND :date_2")->setParameter('date_1', $date[0])
                ->setParameter('date_2', $date[1]);
            }
        
        return $queryBuilder->getQuery()->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Apples
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->
        ;
    }
    */
}
