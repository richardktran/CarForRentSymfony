<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\Car;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CarFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $brandKia = new Brand();
        $brandKia->setName('KIA');
        $manager->persist($brandKia);
        $brandMercedes = new Brand();
        $brandMercedes->setName('Mercedes');
        $manager->persist($brandMercedes);

        $car1 = new Car();
        $car1->setName('Mercedes C200 Exclusive')
            ->setType("C Class")
            ->setBrand($brandMercedes)
            ->setPrice(546)
            ->setImage("https://media.istockphoto.com/photos/red-generic-sedan-car-isolated-on-white-background-3d-illustration-picture-id1189903200?k=20&m=1189903200&s=612x612&w=0&h=L2bus_XVwK5_yXI08X6RaprdFKF1U9YjpN_pVYPgS0o=")
            ->setDescription("Mercedes C200 Exclusive Description")
            ->setCreatedAt(new \DateTime("now"));
        $manager->persist($car1);

        $car2 = new Car();
        $car2->setName('Kia Carens AT')
            ->setType("Carens")
            ->setPrice(789)
            ->setBrand($brandKia)
            ->setImage("https://images.pexels.com/photos/112460/pexels-photo-112460.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500")
            ->setDescription("Kia Carens AT description")
            ->setCreatedAt(new \DateTime("now"));
        $manager->persist($car2);


        $manager->flush();
    }
}
