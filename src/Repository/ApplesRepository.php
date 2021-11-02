<?php

namespace App\Repository;

use App\Entity\Apples;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\Connection;

/**
 * @method Apples[]    getTwoField($xAxisField, $yAxisField, $products, $date)
 * @method Apples[]    getExchange($product, $date)
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
    public function getTwoField($Fields, $products, $date, $like)
    {
        $queryBuilder = $this->createQueryBuilder('a');

        $count = count($Fields);
        for ($i = 0; $i < $count; ++$i) {
            $Fields[$i] = 'a.'.$Fields[$i];
        }
        $queryBuilder->select($Fields, Connection::PARAM_STR_ARRAY);
        
        if($products)
            $queryBuilder->andWhere("a.products IN (:products)")->setParameter('products', $products, Connection::PARAM_STR_ARRAY);
            
        
            if(count($date) == 1){
                $queryBuilder->andWhere("a.date = (:date)")->setParameter('date', $date);
            }else{
                switch ($date[0]) {
                    case 'lessThan':
                        $queryBuilder->andWhere("a.date < :date")->setParameter('date', $date[1]);
                        break;
                    case 'greaterThan':
                        $queryBuilder->andWhere("a.date > :date")->setParameter('date', $date[1]);
                        break;
                    case 'notLessThan':
                        $queryBuilder->andWhere("a.date >= :date")->setParameter('date', $date[1]);
                        break;
                    case 'notGreaterThan':
                        $queryBuilder->andWhere("a.date <= :date")->setParameter('date', $date[1]);
                        break;
                    case 'notEqual':
                        $queryBuilder->andWhere("a.date != :date")->setParameter('date', $date[1]);
                        break;
                    case 'equal':
                        $queryBuilder->andWhere("a.date = :date")->setParameter('date', $date[1]);
                        break;
                    default:
                        $queryBuilder->andWhere("a.date BETWEEN  :date_1 AND :date_2")->setParameter('date_1', $date[0])
                        ->setParameter('date_2', $date[1]);
                        break;
                }                
            }

            if($like){
                $queryBuilder->andWhere("a.{$like['like_column']} LIKE :like_query escape '!'")
                ->setParameter('like_query', $like['like_query']);
            }
        
        return $queryBuilder->getQuery()->getResult();
    }

    
    /**
     * @return Apples[] Returns an array of Apples objects
     */
    public function getExchange($product, $date)
    {
        $queryBuilder = $this->createQueryBuilder('a');

        $queryBuilder->select("a.price", "a.date", "a.price", "a.time", "a.products");

        $queryBuilder->andWhere("a.products = :product")->setParameter('product', $product);

        if(count($date) == 1){
            $queryBuilder->andWhere("a.date = (:date)")->setParameter('date', $date);
        }else{
            $queryBuilder->andWhere("a.date BETWEEN  :date_1 AND :date_2")->setParameter('date_1', $date[0])
            ->setParameter('date_2', $date[1]);
        }

        return $queryBuilder->getQuery()->getResult();
        
    }
}
