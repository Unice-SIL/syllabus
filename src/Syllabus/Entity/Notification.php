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
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

/**
 * Notification
 *
 * @Gedmo\TranslationEntity(class="App\Syllabus\Entity\Translation\NotificationTranslation")
 */
#[
    ApiResource(
        operations: [
            new Get(security: 'is_granted(\'ROLE_API_NOTIFICATION_GET\')'),
            new Put(security: 'is_granted(\'ROLE_API_NOTIFICATION_PUT\')'),
            new Delete(security: 'is_granted(\'ROLE_API_NOTIFICATION_DELETE\')'),
            new GetCollection(security: 'is_granted(\'ROLE_API_NOTIFICATION_GET\')'),
            new Post(security: 'is_granted(\'ROLE_API_NOTIFICATION_POST\')')
        ],
        filters: ['id.search_filter'],
        security: 'is_granted(\'ROLE_API_NOTIFICATION\')'
    )
]
#[ORM\Entity]
#[ORM\Table(name: 'notification')]
class Notification
{
    use TimestampableEntity;

    
    #[ORM\Column(type: 'string', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private int $id;

    /**
     * @Gedmo\Translatable
     */
    #[ORM\Column(name: 'message', type: 'text')]
    private string $message;


    /**
     * Get id.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set message.
     *
     *
     */
    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message.
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
