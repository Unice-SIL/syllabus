<?php


namespace App\Syllabus\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractTranslation;

#[ORM\Entity(repositoryClass: \Gedmo\Translatable\Entity\Repository\TranslationRepository::class)]
#[ORM\Table(name: 'course_section_activity_translations')]
#[ORM\Index(name: 'course_section_activity_translation_idx', columns: ['locale', 'object_class', 'field', 'foreign_key'])]
class CourseSectionActivityTranslation extends AbstractTranslation
{

}