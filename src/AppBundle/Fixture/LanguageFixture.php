<?php


namespace AppBundle\Fixture;


use AppBundle\Entity\Language;
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
        $languages = [
            [
                'label' => self::LANGUAGE_FR,
                'locale' => 'fr'
            ],
            [
                'label' => self::LANGUAGE_EN,
                'locale' => 'en'
            ],
            [
                'label' => self::LANGUAGE_DE,
                'locale' => 'de'
            ],
            [
                'label' => self::LANGUAGE_IT,
                'locale' => 'it'
            ],
            [
                'label' => self::LANGUAGE_ES,
                'locale' => 'es'
            ],
        ];

        foreach ($languages as $l) {

            $language = new Language();

            $language->setLabel($l['label']);
            $language->setLocale($l['locale']);
            $manager->persist($language);
        }
        $manager->flush();
    }
}