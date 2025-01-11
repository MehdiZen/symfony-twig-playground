<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i = 0; $i < 10; $i++){
            $product = new Product();
            $product->setName('Product '.$i);
            $product->setDescription('Product number '.$i.' description');
            $product->setSize(rand(50, 300));
            $manager->persist($product);
        }

        $manager->flush();
    }
}
