<?php

namespace App\Repository;

use App\Entity\BaseEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class BaseRepository extends ServiceEntityRepository
{
    protected string $alias;

    public function __construct(ManagerRegistry $registry, string $entityClass = '', $alias = '')
    {
        parent::__construct($registry, $entityClass);
        $this->alias = $alias;
    }

    public function save(BaseEntity $entity)
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function remove(BaseEntity $entity)
    {
        $this->getEntityManager()->remove($entity);

        $this->getEntityManager()->flush();
    }

    protected function sortBy(QueryBuilder $cars, string $orderBy): QueryBuilder
    {
        if (empty($orderBy)) {
            return $cars;
        }
        $orderBy = explode('.', $orderBy);
        $field = $orderBy[0];
        $order = $orderBy[1];
        switch ($field) {
            case 'created':
                $cars = $cars->orderBy($this->alias . ".createdAt", $order);
                break;

            case 'price':
                $cars = $cars->orderBy($this->alias . ".$field", $order);
                break;
            default:
                break;
        }
        return $cars;
    }


    protected function filter(QueryBuilder $cars, string $field, mixed $value): QueryBuilder
    {
        if (empty($value)) {
            return $cars;
        }
        return $cars->where($this->alias . ".$field = :$field")->setParameter($field, $value);
    }

    protected function andFilter(QueryBuilder $cars, string $field, mixed $value): QueryBuilder
    {
        if (empty($value)) {
            return $cars;
        }
        return $cars->andWhere($this->alias . ".$field = :$field")->setParameter($field, $value);
    }
}
