<?php

namespace App\Tests\Service;

use App\Service\FileUploader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\AsciiSlugger;
use function Symfony\Component\String\u;


class FileUploaderTest extends TestCase
{

    public function testRemove()
    {

        $uploader = new FileUploader(__DIR__ . "/../data", $this->createMock(AsciiSlugger::class));

        $filesystem = new Filesystem();
        $filesystem->copy(__DIR__ . "/../data/image/picture_default.PNG", __DIR__ . "/../data/test_img.png");

        $this->assertFileExists(__DIR__ . "/../data/test_img.png");
        $uploader->remove(['test_img.png']);
        $this->assertFileDoesNotExist(__DIR__ . "/../data/test_img.png");
    }

    public function testUpload()
    {
        $filesystem = new Filesystem();
        $mockSlugger = $this->createMock(AsciiSlugger::class);
        $mockSlugger->expects($this->once())->method('slug')->willReturn(u('toto'));

        $uploader = new FileUploader(__DIR__ . "/../data/", $mockSlugger);

        $filesystem->copy(__DIR__ . "/../data/image/picture_default.PNG", __DIR__ . "/../data/test_img.png");

        $file = new UploadedFile(__DIR__ . "/../data/test_img.png", "test", null, null, true);


        $filename = $uploader->upload($file);

        $this->assertFileExists(__DIR__ . '/../data/' . $filename);
        $filesystem->remove(__DIR__ . '/../data/' . $filename);
    }
}
