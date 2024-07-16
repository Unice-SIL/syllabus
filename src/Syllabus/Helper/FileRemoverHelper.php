<?php

namespace App\Syllabus\Helper;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class FileRemoverHelper
 * @package App\Syllabus\Helper
 */
class FileRemoverHelper
{
    /**
     * @var Filesystem
     */
    private Filesystem $filesystem;

    /**
     * @var string
     */
    private string $filePath;

    /**
     * @param Filesystem $filesystem
     * @param string $filePath
     */
    public function __construct(
        Filesystem $filesystem,
        string $filePath
    )
    {
        $this->filesystem = $filesystem;
        $this->filePath = $filePath;
    }

    /**
     * @param string $fileName
     */
    public function remove(string $fileName)
    {
        $this->filesystem->remove(
            $this->filePath . '/' . $fileName
        );
    }

}