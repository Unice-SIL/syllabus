<?php

namespace AppBundle\Form\Api;

use AppBundle\Entity\CourseInfo;
use AppBundle\Entity\CourseSection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseInfoType extends ApiAbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildApiForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id')
            ->add('title')
            ->add('ects')
            ->add('level')
            ->add('languages')
            ->add('domain')
            ->add('semester')
            ->add('summary')
            ->add('period')
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
            ->add('temPresentationTabValid')
            ->add('temActivitiesTabValid')
            ->add('temObjectivesTabValid')
            ->add('temMccTabValid')
            ->add('temEquipmentsTabValid')
            ->add('temInfosTabValid')
            ->add('temClosingRemarksTabValid')
            ->add('course')
            ->add('structure')
            ->add('lastUpdater')
            ->add('publisher')
            ->add('year')
            ->add('coursePermissions', CollectionType::class, [
                'entry_type' => CoursePermissionType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'error_bubbling' => false,
                'by_reference' => true
            ])
            ->add('courseTeachers', CollectionType::class, [
                'entry_type' => CourseTeacherType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'error_bubbling' => false,
                'by_reference' => false
            ])
            ->add('courseSections', CollectionType::class, [
                'entry_type' => CourseSectionType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'error_bubbling' => false,
                'by_reference' => false
            ])
            ->add('courseAchievements', CollectionType::class, [
                'entry_type' => CourseAchievementType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'error_bubbling' => false,
                'by_reference' => false
            ])
            ->add('coursePrerequisites', CollectionType::class, [
                'entry_type' => CoursePrerequisiteType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'error_bubbling' => false,
                'by_reference' => false
            ])
            ->add('courseTutoringResources', CollectionType::class, [
                'entry_type' => CourseTutoringResourceType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'error_bubbling' => false,
                'by_reference' => false
            ])
            ->add('courseResourceEquipments', CollectionType::class, [
                'entry_type' => CourseResourceEquipmentType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'error_bubbling' => false,
                'by_reference' => false
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
