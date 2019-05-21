<?php

namespace AppBundle\Listener;

use AppBundle\Entity\CourseInfo;
use AppBundle\Helper\FileUploaderHelper;
use AppBundle\Service\LocalFilesystemFileRemover;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class CoursePresentationImageUploadListener
 * @package AppBundle\Listener
 */
class CoursePresentationImageUploadListener
{
    /**
     * @var FileUploaderHelper
     */
    private $fileUploaderHelper;

    /**
     * @var LocalFilesystemFileRemover
     */
    private $localFilesystemFileRemover;

    /**
     * CoursePresentationImageUploadListener constructor.
     * @param FileUploaderHelper $fileUploaderHelper
     */
    public function __construct(
        FileUploaderHelper $fileUploaderHelper,
        LocalFilesystemFileRemover $localFilesystemFileRemover
    )
    {
        $this->fileUploaderHelper = $fileUploaderHelper;
        $this->localFilesystemFileRemover = $localFilesystemFileRemover;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->uploadFile($entity);
    }

    /**
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->uploadFile($entity);
    }

    /**
     * @param PostUpdateEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (true === $entity instanceof CourseInfo) {

            if ($entity->getPreviousImageFile()) {
                $this->localFilesystemFileRemover
                    ->remove($entity->getPreviousImageFile());
            }
        }
    }

    /**
     * @param $entity
     */
    private function uploadFile($entity)
    {
        if (!$entity instanceof CourseInfo) {
            return;
        }

        $file = $entity->getImage();

        if ($file instanceof UploadedFile) {
            $entity->setImage($this->fileUploaderHelper->upload($file));
        } elseif ($file instanceof File) {
            $entity->setImage($file->getFilename());
        }
    }

}