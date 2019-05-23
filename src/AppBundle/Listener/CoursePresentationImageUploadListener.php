<?php

namespace AppBundle\Listener;

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
     * @param PostUpdateEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (true === $entity instanceof CourseInfo) {

            if ($entity->getPreviousImage() &&
                    ($entity->getPreviousImage() !== $entity->getImage())) {
                $this->fileRemoverHelper
                    ->remove($entity->getPreviousImage());
            }
        }
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postLoad(LifecycleEventArgs $args){
        $courseInfo = $args->getEntity();
        if(!$courseInfo instanceof CourseInfo){
            return;
        }
        if($filename = $courseInfo->getImage()){
            $courseInfo->setPreviousImageFile();
            $path = $this->fileUploaderHelper->getDirectory().'/'.$filename;
            if(file_exists($path)) {
                $courseInfo->setImage(new File($path));
            }else{
                $courseInfo->setImage(null);
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

        //$file = $entity->getImage();
        if($file = $entity->getImage()) {

            if ($file instanceof UploadedFile) {
                $entity->setImage($this->fileUploaderHelper->upload($file));
            } elseif ($file instanceof File) {
                $entity->setImage($file->getFilename());
            }
        }
    }

}