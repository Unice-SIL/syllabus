<?php

namespace AppBundle\Form\Api;

use AppBundle\Entity\Campus;
use AppBundle\Entity\Domain;
use AppBundle\Entity\Language;
use AppBundle\Entity\Period;
use AppBundle\Form\Api\Type\ApiCollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseInfoType extends ApiAbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildApiForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', null, [
                'disabled' => true
            ])
            ->add('title')
            ->add('ects')
            ->add('semester')
            ->add('summary')
            ->add('mediaType')
            ->add('image')
            ->add('video')
            ->add('teachingMode')
            ->add('teachingCmClass')
            ->add('teachingTdClass')
            ->add('teachingTpClass')
            ->add('teachingOtherClass')
            ->add('teachingOtherTypeClass')
            ->add('teachingCmHybridClass')
            ->add('teachingTdHybridClass')
            ->add('teachingTpHybridClass')
            ->add('teachingOtherHybridClass')
            ->add('teachingOtherTypeHybridClass')
            ->add('teachingCmHybridDist')
            ->add('teachingTdHybridDist')
            ->add('teachingOtherHybridDist')
            ->add('teachingOtherTypeHybridDistant')
            ->add('teachingCmDist')
            ->add('teachingTdDist')
            ->add('teachingOtherDist')
            ->add('teachingOtherTypeDist')
            ->add('mccWeight')
            ->add('mccCompensable')
            ->add('mccCapitalizable')
            ->add('mccCcCoeffSession1')
            ->add('mccCcNbEvalSession1')
            ->add('mccCtCoeffSession1')
            ->add('mccCtNatSession1')
            ->add('mccCtDurationSession1')
            ->add('mccCtCoeffSession2')
            ->add('mccCtNatSession2')
            ->add('mccCtDurationSession2')
            ->add('mccAdvice')
            ->add('tutoring')
            ->add('tutoringTeacher')
            ->add('tutoringStudent')
            ->add('tutoringDescription')
            ->add('educationalResources')
            ->add('bibliographicResources')
            ->add('agenda')
            ->add('organization')
            ->add('closingRemarks')
            ->add('closingVideo')
            ->add('creationDate', DateTimeType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd hh:ii:ss'
            ])
            ->add('publicationDate', DateTimeType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd hh:ii:ss'
            ])
            ->add('course')
            ->add('structure')
            ->add('publisher')
            ->add('year')
            ->add('languages',EntityType::class, [
                'class' => Language::class,
                'multiple' => true
            ])
            ->add('domains',EntityType::class, [
                'class' => Domain::class,
                'multiple' => true
            ])
            ->add('periods',EntityType::class, [
                'class' => Period::class,
                'multiple' => true
            ])
            ->add('campuses',EntityType::class, [
                'class' => Campus::class,
                'multiple' => true
            ])
            ->add('levels', ApiCollectionType::class, [
                'entry_type' => LevelType::class,
            ])
            ->add('courseTeachers', ApiCollectionType::class, [
                'entry_type' => CourseTeacherType::class,
            ])
            ->add('courseSections', ApiCollectionType::class, [
                'entry_type' => CourseSectionType::class,
            ])
            ->add('courseAchievements', ApiCollectionType::class, [
                'entry_type' => CourseAchievementType::class,
            ])
            ->add('coursePrerequisites', ApiCollectionType::class, [
                'entry_type' => CoursePrerequisiteType::class,
            ])
            ->add('courseTutoringResources', ApiCollectionType::class, [
                'entry_type' => CourseTutoringResourceType::class,
            ])
            ->add('courseResourceEquipments', ApiCollectionType::class, [
                'entry_type' => CourseResourceEquipmentType::class,
            ])
            ->add('teachings', ApiCollectionType::class, [
                'entry_type' => TeachingType::class,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\CourseInfo',
            'csrf_protection' => false
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_courseinfo';
    }


}
