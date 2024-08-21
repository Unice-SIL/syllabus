<?php


namespace App\Syllabus\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractTranslation;

#[ORM\Entity(repositoryClass: \Gedmo\Translatable\Entity\Repository\TranslationRepository::class)]
#[ORM\Table(name: 'structure_translations')]
#[ORM\Index(name: 'structure_translation_idx', columns: ['locale', 'object_class', 'field', 'foreign_key'])]
class StructureTranslation extends AbstractTranslation
{

}