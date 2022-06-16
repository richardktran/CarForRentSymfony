<?php

namespace App\Service;

use App\Repository\CarRepository;
use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

class CarService
{
    private CarRepository $carRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(CarRepository $carRepository, EntityManagerInterface $entityManager)
    {
        $this->carRepository = $carRepository;
        $this->entityManager = $entityManager;
    }

    public function findAll(?array $conditions): array
    {
        $orderBy = $conditions['orderBy'] ?? '';
        $color = $conditions['color'] ?? '';
        $brand = $conditions['brand'] ?? '';
        $seats = $conditions['seats'] ?? '';
        $limit = $conditions['limit'] ?? 10;

        $cars = $this->entityManager->createQueryBuilder()->select('c')->from(Car::class, 'c');
        $cars = $this->filter($cars, 'color', $color);
        $cars = $this->andFilter($cars, 'brand', $brand);
        $cars = $this->andFilter($cars, 'seats', $seats);
        $cars = $this->sortBy($cars, $orderBy);
        $cars->setMaxResults($limit)->setFirstResult(0);

        return $cars->getQuery()->getResult();
    }

    private function sortBy(QueryBuilder $cars, string $orderBy): QueryBuilder
    {
        if (empty($orderBy)) {
            return $cars;
        }
        $orderBy = explode('.', $orderBy);
        $field = $orderBy[0];
        $order = $orderBy[1];
        switch ($field) {
            case 'created':
                $cars = $cars->orderBy("c.createdAt", $order);
                break;

            case 'price':
                $cars = $cars->orderBy("c.$field", $order);
                break;
            default:
                break;
        }
        return $cars;
    }


    private function filter(QueryBuilder $cars, string $field, mixed $value): QueryBuilder
    {
        if (empty($value)) {
            return $cars;
        }
        return $cars->where("c.$field = :$field")->setParameter($field, $value);
    }

    private function andFilter(QueryBuilder $cars, string $field, mixed $value): QueryBuilder
    {
        if (empty($value)) {
            return $cars;
        }
        return $cars->andWhere("c.$field = :$field")->setParameter($field, $value);
    }

}
