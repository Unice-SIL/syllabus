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

/**
 * Notification
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity
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
class Notification
{
    use TimestampableEntity;

    /**
     * @var int
     *
     * @ORM\Column(type="string", unique=true)
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="doctrine.uuid_generator")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     * @Gedmo\Translatable
     */
    private $message;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set message.
     *
     * @param string $message
     *
     * @return Notification
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
