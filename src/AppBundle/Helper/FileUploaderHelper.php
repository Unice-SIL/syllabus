<?php

namespace AppBundle\Helper;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class FileUploaderHelper
 * @package AppBundle\Helper
 */
class FileUploaderHelper
{
    /**
     * @var string|null
     */
    private $directory;

    /**
     * FileUploaderHelper constructor.
     * @param $directory
     */
    public function __construct($directory)
    {
        $this->directory = $directory;
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    public function upload(UploadedFile $file): string
    {
        $filename = md5(uniqid()).'.'.$file->guessExtension();
        try{
            $file->move($this->directory, $filename);
        }catch (FileException $e){
            throw $e;
        }
        return $filename;
    }

    /**
     * @return string
     */
    public function getDirectory(): ?string
    {
        return $this->directory;
    }

}