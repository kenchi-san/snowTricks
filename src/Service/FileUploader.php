<?php


namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;


 class FileUploader
{
    private $targetDirectory;
    private $slugger;

    /**
     * @param $targetDirectory
     * @param SluggerInterface $slugger
     */
    public function __construct($targetDirectory, SluggerInterface $slugger)
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
    }

     /**
      * @param UploadedFile $file
      * @return string
      */
     public function upload(UploadedFile $file)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);

        $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();
        $file->move($this->getTargetDirectory(), $fileName);
        return $fileName;
    }

    /**
     * @param array $images
     */
    public function remove(array $images)
    {
        foreach ($images as $image) {
            if (file_exists($this->getTargetDirectory() . '/' . $image)) {
                unlink($this->getTargetDirectory() . '/' . $image);
            }

        }
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}