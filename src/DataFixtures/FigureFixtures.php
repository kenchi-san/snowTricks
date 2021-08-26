<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Figure;
use App\Entity\Image;
use App\Entity\Video;
use App\Service\FileUploader;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FigureFixtures extends Fixture
{
    /**
     * @var FileUploader
     */
    private $fileUploader;

    /**
     * @param FileUploader $fileUploader
     */
    public function __construct(FileUploader $fileUploader)
    {
        $this->fileUploader = $fileUploader;
    }

    const NB_FIXTURE = 10;

    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {

        $listeFigure = [
            "nameOfFigure" => 'ma figure n°',
            "categories" => ['rider', 'Les grabs', 'Les rotations', 'Les flips', 'Les rotations désaxées', 'Les Slides', ' Les one foot tricks', 'Old School'],
            "links" => ['https://www.youtube.com/embed/M_BOfGX0aGs', 'https://www.youtube.com/embed/mTFMakbP0xw', 'https://www.youtube.com/embed/t705_V-RDcQ', 'https://www.youtube.com/embed/AzJPhQdTRQQ'],
            "contents" => "A ab accusamus, alias aliquid amet assumenda consequuntur deserunt, doloremque ducimus eius eos ex facere, facilis
    inventore ipsam iure necessitatibus numquam perferendis quasi quibusdam quis similique tenetur vel veritatis vero? Aliquid animi aut commodi delectus dolorum ducimus excepturi, facilis fugiat ipsum magnam nam officia pariatur
    praesentium quaerat, ratione ullam, unde. Culpa labore neque nostrum quisquam saepe sit tempore ut. Voluptatem. A ab accusamus, alias aliquid amet assumenda consequuntur deserunt, doloremque ducimus eius eos ex facere, facilis
    inventore ipsam iure necessitatibus numquam perferendis quasi quibusdam quis similique tenetur vel veritatis vero? Aliquid animi aut commodi delectus dolorum ducimus excepturi, facilis fugiat ipsum magnam nam officia pariatur
    praesentium quaerat, ratione ullam, unde. Culpa labore neque nostrum quisquam saepe sit tempore ut. Voluptatem."];

        $MAX_LINKS = count($listeFigure['links']);


        $allCategories = [];
        foreach ($listeFigure['categories'] as $key => $category) {
            $initCategory = new Category();
            $initCategory = $initCategory->setName($category);
            $manager->persist($initCategory);
            $allCategories[] = $initCategory;
        }
        $manager->flush();

        for ($i = 1; $i <= self::NB_FIXTURE; $i++) {
            if (!is_array($listeFigure['categories']) || empty($listeFigure['categories'])) {
                break;
            }
            if (!is_array($listeFigure['links']) || empty($listeFigure['links'])) {
                break;
            }

            $keyLink = random_int(0, $MAX_LINKS - 1);
            $figure = new Figure();
            $video = new Video();
            $filesystem = new Filesystem();
            $image = new Image();

            $figure->setName($listeFigure['nameOfFigure'] . $i);
            $figure->setCategory($allCategories[array_rand($allCategories, 1)]);
            $figure->setContent($listeFigure['contents']);
            $figure->addVideo($video->setLink($listeFigure['links'][$keyLink]));

            $filesystem->copy(__DIR__ . "/data/image/picture_default.PNG", __DIR__ . "/data/image/fixture_img.png");
            $file = new UploadedFile(__DIR__ . "/data/image/fixture_img.png", "fixture", null, null, true);

            $filename = $this->fileUploader->upload($file);
            $image->setName($filename);
            $figure->addImage($image);


            $manager->persist($video);
            $manager->persist($figure);
        }

        $manager->flush();
        $filesystem = new Filesystem();

        $filesystem->copy(__DIR__ . "/data/image/picture.jpg", __DIR__ . "/data/image/firstPicture.jpg",false);
        $file = new UploadedFile(__DIR__ . "/data/image/firstPicture.jpg", "firstPicture", null, null, true);
        $file->move( "public/uploads/figures","firstPicture.jpg");
    }


}
