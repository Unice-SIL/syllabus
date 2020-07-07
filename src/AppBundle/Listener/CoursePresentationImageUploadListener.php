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
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

/**
 * Class CoursePresentationImageUploadListener
 * @package AppBundle\Listener
 */
class CoursePresentationImageUploadListener
{
    const COURSE_INFO_PROP_IMAGE = 'image';
    const COURSE_INFO_PROP_PREVIOUS_IMAGE = 'previousImage';
    const ACTIVITY_TYPE_PROP_ICON = 'icon';
    const ACTIVITY_TYPE_PROP_PREVIOUS_ICON = 'previousIcon';

    /**
     * @var FileUploaderHelper
     */
    private $fileUploaderHelper;
    /**
     * @var FileRemoverHelper
     */
    private $fileRemoverHelper;
    /**
     * @var PropertyAccessor
     */
    private $propertyAccessor;

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
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
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

        if($property = $this->getProperty($entity) === null) return;

        if($previousProperty = $this->getPreviousProperty($entity) !== null)
        {
            $previous = $this->propertyAccessor->getValue($entity, $previousProperty);
            if($previous && $previous !== $this->propertyAccessor->getValue($entity, $property))
            {
                $this->fileRemoverHelper->remove($previous);
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
        }
    }

    /**
     * @param $entity
     */
    public function getFile($entity)
    {
        if($property = $this->getProperty($entity) === null) return;

        if ($filename = $this->propertyAccessor->getValue($entity, $property)) {
            $this->propertyAccessor->setValue($entity, $this->getPreviousProperty($entity), null);
            $path = $this->fileUploaderHelper->getDirectory() . '/' . $filename;
            $value = (file_exists($path))?  new File($path) : null;
            $this->propertyAccessor->setValue($entity, $property, $value);
        }
    }

    /**
     * @param $entity
     */
    private function uploadFile($entity)
    {
        if($property = $this->getProperty($entity) === null) return;

        if ($file = $this->propertyAccessor->getValue($entity, $property)) {
            if ($file instanceof UploadedFile) {
                $this->propertyAccessor->setValue($entity, $property, $this->fileUploaderHelper->upload($file));
            } elseif ($file instanceof File) {
                $this->propertyAccessor->setValue($entity, $property, $file->getFilename());
                $entity->setImage($file->getFilename());
            }
        }
    }

    /**
     * @param $entity
     * @return string|null
     */
    private function getProperty($entity)
    {
        $property = null;
        if($entity instanceof  CourseInfo) $property = self::COURSE_INFO_PROP_IMAGE;
        if($entity instanceof  ActivityType) $property = self::ACTIVITY_TYPE_PROP_ICON;
        return $property;
    }

    /**
     * @param $entity
     * @return string|null
     */
    private function getPreviousProperty($entity)
    {
        $property = null;
        if($entity instanceof  CourseInfo) $property = self::COURSE_INFO_PROP_PREVIOUS_IMAGE;
        if($entity instanceof  ActivityType) $property = self::ACTIVITY_TYPE_PROP_PREVIOUS_ICON;
        return $property;
    }
}