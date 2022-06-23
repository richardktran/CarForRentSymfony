<?php

namespace App\Tests\Entity;

use App\Entity\Car;
use DateTime;
use PHPUnit\Framework\TestCase;

class CarTest extends TestCase
{
    private DateTime $now;

    protected function setUp(): void
    {
        parent::setUp();
        $this->now = new \DateTime('now');
    }

    public function testCarCreate(): void
    {
        $coffee = new Car();

        $this->assertEquals(Car::class, get_class($coffee));
    }

    /**
     * @dataProvider carProvider
     */
    public function testCarCheckProperties(array $params, array $expected): void
    {
        $car = new Car();
        $car->setName($params['name'])
            ->setDescription($params['description'])
            ->setColor($params['color'])
            ->setBrand($params['brand'])
            ->setPrice($params['price'])
            ->setSeats($params['seats'])
            ->setYear($params['year'])
            ->setCreatedAt($this->now);
        $this->assertEquals($expected['name'], $car->getName());
        $this->assertEquals($expected['description'], $car->getDescription());
        $this->assertEquals($expected['color'], $car->getColor());
        $this->assertEquals($expected['brand'], $car->getBrand());
        $this->assertEquals($expected['price'], $car->getPrice());
        $this->assertEquals($expected['seats'], $car->getSeats());
        $this->assertEquals($expected['year'], $car->getYear());
        $this->assertEquals($this->now, $car->getCreatedAt());
    }

    public function carProvider()
    {
        return [
            'case-1' => [
                'params' => [
                    'name' => 'Hyundai RC2',
                    'description' => 'Hyundai RC2 description',
                    'color' => 'red',
                    'brand' => 'Hyundai',
                    'price' => 10.1,
                    'seats' => 4,
                    'year' => 2020,
                ],
                'expected' => [
                    'name' => 'Hyundai RC2',
                    'description' => 'Hyundai RC2 description',
                    'color' => 'red',
                    'brand' => 'Hyundai',
                    'price' => 10.1,
                    'seats' => 4,
                    'year' => 2020,
                ]
            ]
        ];
    }
}
