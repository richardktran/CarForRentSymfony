<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ImageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->loadUsers($manager);
    }

    private function loadUsers(ObjectManager $manager): void
    {
        foreach ($this->getImageData() as [$id, $path]) {
            $image = new Image();
            $image->setPath($path);

            $manager->persist($image);
            $this->addReference('image_'.$id, $image);
        }

        $manager->flush();
    }

    private function getImageData(): array
    {
        return [
            [1, 'https://media.istockphoto.com/photos/red-generic-sedan-car-isolated-on-white-background-3d-illustration-picture-id1189903200?k=20&m=1189903200&s=612x612&w=0&h=L2bus_XVwK5_yXI08X6RaprdFKF1U9YjpN_pVYPgS0o='],
            [2, 'https://autopro8.mediacdn.vn/2022/5/7/27984339532627645340455667220452524146149354n-16518960833771134193183-16518967534471523576277.png500'],
            [3, 'https://images.pexels.com/photos/112460/pexels-photo-112460.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500'],
        ];
    }
}
