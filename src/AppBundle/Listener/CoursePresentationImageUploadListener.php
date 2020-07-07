<?php

namespace AppBundle\Listener;

use AppBundle\Entity\ActivityType;
use AppBundle\Entity\CourseInfo;
use AppBundle\Helper\FileUploaderHelper;
use AppBundle\Helper\FileRemoverHelper;
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
     * @var FileRemoverHelper
     */
    private $fileRemoverHelper;

    /**
     * CoursePresentationImageUploadListener constructor.
     * @param FileUploaderHelper $fileUploaderHelper
     * @param FileRemoverHelper $fileRemoverHelper
     */
    public function __construct(
        FileUploaderHelper $fileUploaderHelper,
        FileRemoverHelper $fileRemoverHelper
    )
    {
        $this->fileUploaderHelper = $fileUploaderHelper;
        $this->fileRemoverHelper = $fileRemoverHelper;
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
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof CourseInfo) {

            if ($entity->getPreviousImage() &&
                ($entity->getPreviousImage() !== $entity->getImage())) {
                $this->fileRemoverHelper
                    ->remove($entity->getPreviousImage());
            }
        } elseif ($entity instanceof ActivityType) {
            if ($entity->getPreviousIcon() &&
                ($entity->getPreviousIcon() !== $entity->getIcon())) {
                $this->fileRemoverHelper
                    ->remove($entity->getPreviousIcon());
            }
        }
        $this->getFile($entity);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof CourseInfo || $entity instanceof ActivityType){
            $this->getFile($entity);
        }else{
            return;
        }

    }

    /**
     * @param CourseInfo $courseInfo
     */
    public function getFile($entity)
    {
        if ($entity instanceof CourseInfo) {
            $courseInfo = $entity;
            if ($filename = $courseInfo->getImage()) {
                $courseInfo->setPreviousImage();
                $path = $this->fileUploaderHelper->getDirectory() . '/' . $filename;
                if (file_exists($path)) {
                    $courseInfo->setImage(new File($path));
                } else {
                    $courseInfo->setImage(null);
                }
            }
        } elseif ($entity instanceof ActivityType) {
            $activityType = $entity;
            if ($filename = $activityType->getIcon()) {
                $activityType->setPreviousIcon();
                $path = $this->fileUploaderHelper->getDirectory() . '/' . $filename;
                if (file_exists($path)) {
                    $activityType->setIcon(new File($path));
                } else {
                    $activityType->setIcon(null);
                }
            }
        }
    }

    /**
     * @param $entity
     */
    private function uploadFile($entity)
    {


        if ($entity instanceof CourseInfo) {
            //$file = $entity->getImage();
            if ($file = $entity->getImage()) {

                if ($file instanceof UploadedFile) {
                    $entity->setImage($this->fileUploaderHelper->upload($file));
                } elseif ($file instanceof File) {
                    $entity->setImage($file->getFilename());
                }
            }
        }elseif ($entity instanceof ActivityType){
            if ($file = $entity->getIcon()) {

                if ($file instanceof UploadedFile) {
                    $entity->setIcon($this->fileUploaderHelper->upload($file));
                } elseif ($file instanceof File) {
                    $entity->setIcon($file->getFilename());
                }
            }
        }else{
            return;
        }
    }

}