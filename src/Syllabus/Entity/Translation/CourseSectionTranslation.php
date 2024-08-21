<?php


namespace App\Syllabus\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractTranslation;

#[ORM\Entity(repositoryClass: \Gedmo\Translatable\Entity\Repository\TranslationRepository::class)]
#[ORM\Table(name: 'course_section_translations')]
#[ORM\Index(name: 'course_section_translation_idx', columns: ['locale', 'object_class', 'field', 'foreign_key'])]
class CourseSectionTranslation extends AbstractTranslation
{

}