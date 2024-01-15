<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\City;
use App\Entity\Country;
use App\Entity\Item;
use App\Entity\Material;
use App\Entity\Service;
use App\Entity\OrderStatus;
use Doctrine\Bundle\FixturesBundle\Fixture; 
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{ 
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");

        $countries = [];

        for ($i = 0; $i < 5; $i++) {
            $country = new Country();
            $country->setCountry($faker->country());
            
            $manager->persist($country);

            $countries[] = $country;
        }
        
        for ($i = 0; $i < 5; $i++) {
            $city = new City();
            $city->setCity($faker->city())
                ->setZipcode($faker->numberBetween(10000, 99999))
                ->setCountry($faker->randomElement($countries));

            $manager->persist($city);
        }

        $categories = [];

        for ($i = 0; $i < 1; $i++) {
            $category = new Category;
            $category->setCategoryName($faker->word())
                ->setParent($faker->randomElement($categories));

            $manager->persist($category);

            $categories[] = $category;
        }

        for ($i = 0; $i < 1; $i++) {
            $item = new Item();
            $item->setName($faker->word())
                ->setDescription($faker->realTextBetween(50, 80))
                ->setState($faker->word())
                ->setPrice($faker->randomFloat(20, 30, 40))
                ->setCategory($faker->randomElement($categories));
                
            $manager->persist($item); 
        }

        for ($i = 0; $i < 5; $i++) {
            $material = new Material(); 
            $material->setType($faker->word())
                ->setPriceCoeff($faker->numberBetween(1, 3));

            $manager->persist($material); 
        }

        for ($i = 0; $i < 5; $i++) {
            $service = new Service();  
            $service->setName($faker->word())
                ->setPriceCoeff($faker->numberBetween(1, 3));

            $manager->persist($service);  
        }

        for ($i = 0; $i < 5; $i++) {
            $order_status = new OrderStatus();   
            $order_status->setStatus($faker->word());

            $manager->persist($order_status); 
        }

        $manager->flush();
    }
}
