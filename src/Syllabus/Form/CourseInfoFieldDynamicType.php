<?php

namespace App\Syllabus\Form;

use App\Syllabus\Entity\CourseInfoField;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CourseInfoFieldDynamicType extends AbstractType
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $fields = $this->entityManager->getRepository(CourseInfoField::class)->findAll();
        foreach ($fields as $field) {
            $builder->add($field->getField(), CourseInfoFieldType::class, [
                'label' => $field->getLabel(),
                'data' => $field
            ]);
        }
    }
}