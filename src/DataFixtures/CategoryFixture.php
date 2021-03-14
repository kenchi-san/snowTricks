<?php


namespace App\DataFixtures;


use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i <= 4; $i++) {
            $category = new Category();
            $category->setName('categorie n°' . $i);
            $manager->persist($category);
            $manager->flush();
        }

    }
}