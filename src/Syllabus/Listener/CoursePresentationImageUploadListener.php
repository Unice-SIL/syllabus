<?php

namespace App\Syllabus\Listener;

use App\Syllabus\Entity\ActivityType;
use App\Syllabus\Entity\CourseInfo;
use App\Syllabus\Helper\FileUploaderHelper;
use App\Syllabus\Helper\FileRemoverHelper;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

/**
 * Class CoursePresentationImageUploadListener
 * @package App\Syllabus\Listener
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
    private FileUploaderHelper $fileUploaderHelper;
    /**
     * @var FileRemoverHelper
     */
    private FileRemoverHelper $fileRemoverHelper;
    /**
     * @var PropertyAccessor
     */
    private PropertyAccessor $propertyAccessor;

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
    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();
        $this->uploadFile($entity);
    }

    /**
     * @param PreUpdateEventArgs $args
     */
    public function preUpdate(PreUpdateEventArgs $args): void
    {
        $entity = $args->getEntity();
        $this->uploadFile($entity);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();

        $property = $this->getProperty($entity);
        if ($property === null) return;

        $previousProperty = $this->getPreviousProperty($entity);
        if ($previousProperty !== null) {
            $previous = $this->propertyAccessor->getValue($entity, $previousProperty);
            if ($previous && $previous !== $this->propertyAccessor->getValue($entity, $property)) {
                $this->fileRemoverHelper->remove($previous);
            }
        }

        $this->getFile($entity);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postLoad(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();
        if ($entity instanceof CourseInfo || $entity instanceof ActivityType) {
            $this->getFile($entity);
        }
    }

    /**
     * @param $entity
     */
    public function getFile($entity): void
    {
        $property = $this->getProperty($entity);
        if ($property === null) return;

        if ($filename = $this->propertyAccessor->getValue($entity, $property)) {
            $this->propertyAccessor->setValue($entity, $this->getPreviousProperty($entity), $filename);
            $path = $this->fileUploaderHelper->getDirectory() . '/' . $filename;
            $value = (file_exists($path)) ? new File($path) : null;
            $this->propertyAccessor->setValue($entity, $property, $value);
        }
    }

    /**
     * @param $entity
     */
    private function uploadFile($entity): void
    {
        $property = $this->getProperty($entity);
        if ($property === null)  return;

        if ($file = $this->propertyAccessor->getValue($entity, $property)) {
            if ($file instanceof UploadedFile) {
                $this->propertyAccessor->setValue($entity, $property, $this->fileUploaderHelper->upload($file));
            } elseif ($file instanceof File) {
                $this->propertyAccessor->setValue($entity, $property, $file->getFilename());
            }
        }
    }

    /**
     * @param $entity
     * @return string|null
     */
    private function getProperty($entity): ?string
    {
        if ($entity instanceof CourseInfo) return self::COURSE_INFO_PROP_IMAGE;
        if ($entity instanceof ActivityType) return self::ACTIVITY_TYPE_PROP_ICON;
        return null;
    }

    /**
     * @param $entity
     * @return string|null
     */
    private function getPreviousProperty($entity): ?string
    {
        if ($entity instanceof CourseInfo) return self::COURSE_INFO_PROP_PREVIOUS_IMAGE;
        if ($entity instanceof ActivityType) return self::ACTIVITY_TYPE_PROP_PREVIOUS_ICON;
        return null;
    }
}