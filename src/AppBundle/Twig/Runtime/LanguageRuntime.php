<?php


namespace AppBundle\Twig\Runtime;

use AppBundle\Entity\Language;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\RuntimeExtensionInterface;

class LanguageRuntime implements RuntimeExtensionInterface
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * LanguageRuntime constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getLanguages()
    {
        return $this->em->getRepository(Language::class)->findAll();
    }
}