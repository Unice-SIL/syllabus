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
 * @ORM\Table(name="course_info_field")
 * @ORM\Entity
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
class CourseInfoField
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="field", type="string", length=150, nullable=false, unique=true)
     */
    private $field;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=150, nullable=false, unique=true)
     * @Gedmo\Translatable
     */
    private $label;

    /**
     * @var bool
     *
     * @ORM\Column(name="manually_duplication", type="boolean", nullable=false, options={"default" : 0})
     */
    private $manuallyDuplication = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="automatic_duplication", type="boolean", nullable=false, options={"default" : 0})
     */
    private $automaticDuplication = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="import", type="boolean", nullable=false, options={"default" : 0})
     */
    private $import = 0;

    /**
     * CourseInfoField constructor.
     * @param string $field
     */
    public function __construct(?string $field)
    {
        $this->field = $field;
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param string $field
     */
    public function setField($field)
    {
        $this->field = $field;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return $this
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return bool
     */
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

    /**
     * @return bool
     */
    public function getAutomaticDuplication(): bool
    {
        return $this->automaticDuplication;
    }

    /**
     * @param bool $automaticDuplication
     * @return CourseInfoField
     */
    public function setAutomaticDuplication($automaticDuplication): self
    {
        $this->automaticDuplication = $automaticDuplication;

        return $this;
    }

    /**
     * @return bool
     */
    public function isImport()
    {
        return $this->import;
    }

    /**
     * @param bool $import
     */
    public function setImport($import)
    {
        $this->import = $import;
    }
}
