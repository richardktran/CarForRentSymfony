<?php

namespace App\Manager;

use Aws\Result;
use Aws\S3\S3Client;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileManager
{
    private string $targetDirectory;
    private string $bucketName;
    private S3Client $s3Client;
    private SluggerInterface $slugger;
    private ContainerBagInterface $params;

    public function __construct(string $targetDirectory, string $bucketName, S3Client $s3Client, SluggerInterface $slugger, ContainerBagInterface $params)
    {
        $this->targetDirectory = $targetDirectory;
        $this->bucketName = $bucketName;
        $this->s3Client = $s3Client;
        $this->slugger = $slugger;
        $this->params = $params;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function upload(UploadedFile $file): string
    {
        $fileName = $this->getFileName($file);
        $file->move($this->targetDirectory, $fileName);
        $filePath = $this->targetDirectory.$fileName;
        $filePut = $this->s3Put($fileName, $filePath);
        unlink($filePath);
        $s3Path = $filePut->get('ObjectURL');

        return $this->getRelativePath($s3Path);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function getRelativePath(string $fullPath): string
    {
        $s3Url = $this->params->get('s3url');

        return substr($fullPath, strlen($s3Url));
    }

    private function getFileName(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);

        return $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
    }

    private function s3Put(string $key, string $filePath): Result
    {
        return $this->s3Client->putObject([
            'Bucket' => $this->bucketName,
            'Key' => 'car/img'.$key,
            'SourceFile' => $filePath,
        ]);
    }
}
