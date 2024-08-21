<?php

namespace App\Syllabus\Entity;

use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiFilter;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CourseInfoField
 *
 * @Gedmo\TranslationEntity(class="App\Syllabus\Entity\Translation\CourseInfoFieldTranslation")
 */
#[
    ApiResource(
        operations: [
            new Get(security: 'is_granted(\'ROLE_API_COURSE_INFO_FIELD_GET\')'),
            new Put(security: 'is_granted(\'ROLE_API_COURSE_INFO_FIELD_PUT\')'),
            new Delete(security: 'is_granted(\'ROLE_API_COURSE_INFO_FIELD_DELETE\')'),
            new GetCollection(security: 'is_granted(\'ROLE_API_COURSE_INFO_FIELD_GET\')'),
            new Post(security: 'is_granted(\'ROLE_API_COURSE_INFO_FIELD_POST\')')
        ], filters: ['id.search_filter', 'label.search_filter'],
        security: 'is_granted(\'ROLE_API_COURSE_INFO_FIELD\')'
    )
]
#[ORM\Entity]
#[ORM\Table(name: 'course_info_field')]
class CourseInfoField
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    
    #[ORM\Column(name: 'field', type: 'string', length: 150, unique: true, nullable: false)]
    private ?string $field;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'label', type: 'string', length: 150, unique: true, nullable: false)]
    private string $label;

    
    #[ORM\Column(name: 'manually_duplication', type: 'boolean', nullable: false, options: ['default' => 0])]
    private bool $manuallyDuplication = false;

    
    #[ORM\Column(name: 'automatic_duplication', type: 'boolean', nullable: false, options: ['default' => 0])]
    private bool $automaticDuplication = false;

    
    #[ORM\Column(name: 'import', type: 'boolean', nullable: false, options: ['default' => 0])]
    private bool $import = false;

    /**
     * CourseInfoField constructor.
     */
    public function __construct(?string $field)
    {
        $this->field = $field;
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getField(): ?string
    {
        return $this->field;
    }

    public function setField(string $field): void
    {
        $this->field = $field;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @return $this
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    public function getManuallyDuplication(): bool
    {
        return $this->manuallyDuplication;
    }

    /**
     * @param $manuallyDuplication
     * @return $this
     */
    public function setManuallyDuplication($manuallyDuplication): self
    {
        $this->manuallyDuplication = $manuallyDuplication;

        return $this;
    }

    public function getAutomaticDuplication(): bool
    {
        return $this->automaticDuplication;
    }

    public function setAutomaticDuplication(bool $automaticDuplication): self
    {
        $this->automaticDuplication = $automaticDuplication;

        return $this;
    }

    public function isImport(): bool
    {
        return $this->import;
    }

    public function setImport(bool $import): void
    {
        $this->import = $import;
    }
}
