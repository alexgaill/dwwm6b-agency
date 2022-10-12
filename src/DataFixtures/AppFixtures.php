<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Property;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i=0; $i < 10; $i++) { 
            $transactionType = $faker->boolean();
            $propertyType = $faker->numberBetween(0,2);
            $rooms = $faker->numberBetween(1, 7);
            $size = $faker->numberBetween(8, 15) * $rooms;
            if ($transactionType) {
                $price = $faker->numberBetween(3500, 10000) * $size;
            } else {
                $price = $faker->numberBetween(20, 50) * $size;
            }

            $property = (new Property)
                ->setTitle($faker->sentence())
                ->setContent($faker->paragraphs(2, true))
                ->setTransactionType($transactionType)
                ->setSize($size)
                ->setGroundSize($propertyType === 0 ? null : $faker->randomNumber(4))
                ->setRooms($rooms)
                ->setFloor($propertyType === 0 ? $faker->numberBetween(0, 5): 0)
                ->setAddress($faker->streetAddress())
                ->setPostalCode($faker->postCode())
                ->setCity($faker->city())
                ->setPrice($price)
                ->setPropertyType($propertyType)
                ->setAvailable(true)
                ;
            $manager->persist($property);
        }

        $manager->flush();
    }
}
