<?php


namespace App\Syllabus\Fixture;


use App\Syllabus\Entity\Language;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class LanguageFixture extends Fixture  implements FixtureGroupInterface
{
    public const LANGUAGE_FR = 'Francais';
    public const LANGUAGE_EN = 'Anglais';
    public const LANGUAGE_DE = 'Allemand';
    public const LANGUAGE_IT = 'Italien';
    public const LANGUAGE_ES = 'Espagnol';

    public static function getGroups(): array
    {
        return ['test'];
    }

    public function load(ObjectManager $manager)
    {

        $language = new Language();
        $language->setLabel(self::LANGUAGE_FR);
        $this->addReference(self::LANGUAGE_FR, $language);
        $manager->persist($language);

        $languages = [
            [
                'label' => self::LANGUAGE_FR,
            ],
            [
                'label' => self::LANGUAGE_EN,
            ],
            [
                'label' => self::LANGUAGE_DE,
            ],
            [
                'label' => self::LANGUAGE_IT,
            ],
            [
                'label' => self::LANGUAGE_ES,
            ],
        ];

        foreach ($languages as $l) {

            $language = new Language();

            $language->setLabel($l['label']);
            $manager->persist($language);
        }
        $manager->flush();
    }
}