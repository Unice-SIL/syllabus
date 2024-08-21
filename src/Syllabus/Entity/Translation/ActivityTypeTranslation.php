<?php


namespace App\Syllabus\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractTranslation;

#[ORM\Entity(repositoryClass: \Gedmo\Translatable\Entity\Repository\TranslationRepository::class)]
#[ORM\Table(name: 'activity_type_translations')]
#[ORM\Index(name: 'activity_type_translation_idx', columns: ['locale', 'object_class', 'field', 'foreign_key'])]
class ActivityTypeTranslation extends AbstractTranslation
{

}