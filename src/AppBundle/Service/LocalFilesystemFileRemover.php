<?php

// src/AppBundle/Service/LocalFilesystemFileRemover.php

namespace AppBundle\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

class LocalFilesystemFileRemover
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var string
     */
    private $filePath;

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
     * @param Filesystem $filesystem
     * @param string $fileName
     */
    public function remove($fileName)
    {
        $this->filesystem->remove(
            $this->filePath . '/' . $fileName
        );
    }

}
