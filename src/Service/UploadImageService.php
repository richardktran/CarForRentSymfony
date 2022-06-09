<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

class UploadImageService
{
    private $targetDirectory;
    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(?UploadedFile $image): string
    {
        if($image==null){
            return "";
        }
        $newImageName = uniqid() . '.' . $image->guessExtension();
        try {
            $image->move(
                $this->targetDirectory,
                $newImageName
            );
        } catch (FileException $exception) {
            return "";
        }
        return $newImageName;
    }
}
