<?php

namespace AppBundle\Listener;

use AppBundle\Entity\CourseInfo;
use AppBundle\Helper\FileUploaderHelper;
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
     * CoursePresentationImageUploadListener constructor.
     * @param FileUploaderHelper $fileUploaderHelper
     */
    public function __construct(FileUploaderHelper $fileUploaderHelper)
    {
        $this->fileUploaderHelper = $fileUploaderHelper;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args){
        $entity = $args->getEntity();
        $this->uploadFile($entity);
    }

    /**
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args){
        $entity = $args->getEntity();
        $this->uploadFile($entity);
    }

    /**
     * @param $entity
     */
    private function uploadFile($entity)
    {
        if(!$entity instanceof CourseInfo){
            return;
        }

        $file = $entity->getImage();

        if($file instanceof UploadedFile){
            $filename = $this->fileUploaderHelper->upload($file);
            $entity->setImage($filename);
        }elseif ($file instanceof File){
            $entity->setImage($file->getFilename());
        }
    }

}