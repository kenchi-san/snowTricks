<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Figure;
use App\Entity\Image;
use App\Entity\User;
use App\Entity\Video;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use PhpParser\Node\Scalar\String_;

class FigureFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $names = 'ma figure n°';
        $categories = ['rider', 'Les grabs', 'Les rotations', 'Les flips', 'Les rotations désaxées', 'Les Slides', ' Les one foot tricks', 'Old School'];
        $links = ['https://www.youtube.com/watch?v=M_BOfGX0aGs', 'https://www.youtube.com/watch?v=mTFMakbP0xw', 'https://www.youtube.com/watch?v=t705_V-RDcQ', 'https://www.youtube.com/watch?v=AzJPhQdTRQQ'];
        $pictures = '';
        $contents = "A ab accusamus, alias aliquid amet assumenda consequuntur deserunt, doloremque ducimus eius eos ex facere, facilis
    inventore ipsam iure necessitatibus numquam perferendis quasi quibusdam quis similique tenetur vel veritatis vero? Aliquid animi aut commodi delectus dolorum ducimus excepturi, facilis fugiat ipsum magnam nam officia pariatur
    praesentium quaerat, ratione ullam, unde. Culpa labore neque nostrum quisquam saepe sit tempore ut. Voluptatem. A ab accusamus, alias aliquid amet assumenda consequuntur deserunt, doloremque ducimus eius eos ex facere, facilis
    inventore ipsam iure necessitatibus numquam perferendis quasi quibusdam quis similique tenetur vel veritatis vero? Aliquid animi aut commodi delectus dolorum ducimus excepturi, facilis fugiat ipsum magnam nam officia pariatur
    praesentium quaerat, ratione ullam, unde. Culpa labore neque nostrum quisquam saepe sit tempore ut. Voluptatem.";





        for ($i = 0; $i <= 10; $i++) {
            $figure = new Figure();
            $category = new Category();
            $image = new Image();
            $user = new User();
            $video = new Video();

            $figure->setName($names . $i);
            $figure->setCategory($categories[$i]);
            $figure->setContent($contents);
            $figure->addVideo();
            $figure->addImage();

            $image->setName();

            $category->setName();

            $video->setLink();


        }


        $manager->flush();
    }
}
