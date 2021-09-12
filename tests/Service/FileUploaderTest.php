<?php

namespace App\Tests\Service;

use App\Service\FileUploader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\AsciiSlugger;

class FileUploaderTest extends TestCase
{

    public function testRemove()
    {

        $uploader = new FileUploader("D:\wamp64\www\snowTricks/public/uploads/figures", $this->createMock(AsciiSlugger::class));

        $filesystem = new Filesystem();
        $filesystem->copy("D:\wamp64\www\snowTricks/tests/data/image/picture_default.PNG", "D:\wamp64\www\snowTricks/public/uploads/figures/test_img.png");

        $file = new UploadedFile("D:\wamp64\www\snowTricks/public/uploads/figures/test_img.png", "test", null, null, false);
        $uploader->remove(["images" => $file->getBasename()]);
        $this->assertFileDoesNotExist($file->getBasename());


    }

}
