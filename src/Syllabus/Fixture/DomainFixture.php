<?php


namespace App\Syllabus\Fixture;


use App\Syllabus\Entity\Domain;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class DomainFixture extends Fixture  implements FixtureGroupInterface
{
    public const DOMAIN_1 = 'Science';
    public const DOMAIN_2 = 'Littéraire';
    public const DOMAIN_3 = 'Biologie';

    public function load(ObjectManager $manager)
    {

        $demain = new Domain();
        $demain->setLabel(self::DOMAIN_1);
        $this->addReference(self::DOMAIN_1, $demain);
        $manager->persist($demain);

        $domains = [
            [
                'label' => self::DOMAIN_1
            ],
            [
                'label' => self::DOMAIN_2
            ],
            [
                'label' => self::DOMAIN_3
            ],
        ];

        foreach ($domains as $d) {

            $domain = new Domain();
            $domain->setLabel($d['label']);
            $manager->persist($domain);
        }
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['test'];
    }
}