<?php


namespace AppBundle\Command\Migration;


use AppBundle\Entity\Domain;
use AppBundle\Entity\Structure;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class DomainMigration
 * @package AppBundle\Command\Migration
 */
class DomainMigration extends AbstractReferentialMigration
{

    protected static $defaultName = 'app:domain-migration';

    /**
     * @var array
     */
    private $structures;

    /**
     * DomainMigration constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);

        $this->structures = [];
        /** @var Structure $structure */
        foreach($this->em->getRepository(Structure::class)->findAll() as $structure)
        {
            $this->structures[$structure->getCode()] = $structure;
        }
    }

    /**
     * @return string
     */
    protected function getStartMessage(): string
    {
        return 'Start of domains creation';
    }

    /**
     * @return string
     */
    protected function getEndMessage(): string
    {
        return 'End of domains creation';
    }

    /**
     * @return string
     */
    protected function getEntityClassName(): string
    {
        return Domain::class;
    }

    /**
     * @return array
     */
    protected function getEntities(): array
    {
        $domains = [];

        // Anthropologie
        $domain = new Domain();
        $domain->setCode('001')
            ->setLabel('Anthropologie');
        $this->addStructures($domain, ['LAS', 'LA']);
        $domains[] = $domain;

        // Arts
        $domain = new Domain();
        $domain->setCode('002')
            ->setLabel('Arts');
        $this->addStructures($domain, ['LAS', 'LA', 'ESP', 'UFM']);
        $domains[] = $domain;

        // Arts du spectacle
        $domain = new Domain();
        $domain->setCode('003')
            ->setLabel('Arts du spectacle');
        $this->addStructures($domain, ['LAS', 'LA']);
        $domains[] = $domain;

        // Biologie
        $domain = new Domain();
        $domain->setCode('004')
            ->setLabel('Biologie');
        $this->addStructures($domain, ['ESP', 'UFM', 'PAS', 'ST', 'SCI', 'SC']);
        $domains[] = $domain;

        // Chimie
        $domain = new Domain();
        $domain->setCode('005')
            ->setLabel('Chimie ');
        $this->addStructures($domain, ['ESP', 'UFM', 'PAS', 'ST', 'SCI', 'SC']);
        $domains[] = $domain;

        // Commerce
        $domain = new Domain();
        $domain->setCode('006')
            ->setLabel('Commerce ');
        $this->addStructures($domain, ['ESP', 'UFM', 'PAS', 'ST', 'SCI', 'SC']);
        $domains[] = $domain;

        // Droit
        $domain = new Domain();
        $domain->setCode('007')
            ->setLabel('Droit ');
        $this->addStructures($domain, ['DRT', 'DR', 'IDP', 'IE', 'IEM']);
        $domains[] = $domain;

        // Electronique
        $domain = new Domain();
        $domain->setCode('008')
            ->setLabel('Electronique ');
        $this->addStructures($domain, ['TIC', 'TIM', 'TIS', 'TIU']);
        $domains[] = $domain;

        // Environnement
        $domain = new Domain();
        $domain->setCode('009')
            ->setLabel('Environnement ');
        $this->addStructures($domain, ['SC', 'SCI', 'IDP']);
        $domains[] = $domain;

        // Ethnologie
        $domain = new Domain();
        $domain->setCode('010')
            ->setLabel('Ethnologie ');
        $this->addStructures($domain, ['LAS', 'LA']);
        $domains[] = $domain;

        // Ergonomie
        $domain = new Domain();
        $domain->setCode('011')
            ->setLabel('Ergonomie ');
        $this->addStructures($domain, ['LAS', 'LA']);
        $domains[] = $domain;

        // FLES
        $domain = new Domain();
        $domain->setCode('012')
            ->setLabel('FLES (Français Langue Etrangère et Secondaire) ');
        $this->addStructures($domain, ['LAS', 'LA']);
        $domains[] = $domain;

        // Géographie et Aménagement
        $domain = new Domain();
        $domain->setCode('014')
            ->setLabel('Géographie et Aménagement');
        $this->addStructures($domain, ['SCI', 'SC', 'ESP', 'UFM']);
        $domains[] = $domain;

        // Histoire
        $domain = new Domain();
        $domain->setCode('015')
            ->setLabel('Histoire');
        $this->addStructures($domain, ['LA', 'LAS', 'ESP', 'UFM', 'DR', 'DRT']);
        $domains[] = $domain;

        // Informatique
        $domain = new Domain();
        $domain->setCode('016')
            ->setLabel('Informatique');
        $this->addStructures($domain, ['SCI', 'SC', 'TIC', 'TIM', 'TIS', 'TIU', 'IEM', 'IE']);
        $domains[] = $domain;

        // LEA
        $domain = new Domain();
        $domain->setCode('017')
            ->setLabel('LEA (Langues Etrangères Appliquées)');
        $this->addStructures($domain, ['LA', 'LAS']);
        $domains[] = $domain;

        // Lettres modernes et classiques
        $domain = new Domain();
        $domain->setCode('018')
            ->setLabel('Lettres modernes et classiques');
        $this->addStructures($domain, ['LA', 'LAS']);
        $domains[] = $domain;

        // LLCER
        $domain = new Domain();
        $domain->setCode('019')
            ->setLabel('LLCER (Langues, littératures et étrangères et régionales)');
        $this->addStructures($domain, ['LA', 'LAS']);
        $domains[] = $domain;

        // Maïeutique
        $domain = new Domain();
        $domain->setCode('020')
            ->setLabel('Maïeutique');
        $this->addStructures($domain, ['SC', 'SCI', 'ME', 'MED']);
        $domains[] = $domain;

        // Mathématiques
        $domain = new Domain();
        $domain->setCode('021')
            ->setLabel('Mathématiques');
        $this->addStructures($domain, ['ST', 'PAS', 'SC', 'SCI', 'UFM', 'ESP', 'IEM', 'IE']);
        $domains[] = $domain;

        // Médecine
        $domain = new Domain();
        $domain->setCode('022')
            ->setLabel('Médecine');
        $this->addStructures($domain, ['ME', 'MED']);
        $domains[] = $domain;

        // MIASHS
        $domain = new Domain();
        $domain->setCode('023')
            ->setLabel('MIASHS');
        $this->addStructures($domain, ['SC', 'SCI']);
        $domains[] = $domain;

        // Musicologie
        $domain = new Domain();
        $domain->setCode('024')
            ->setLabel('Musicologie');
        $this->addStructures($domain, ['LA', 'LAS']);
        $domains[] = $domain;

        // Odontologie
        $domain = new Domain();
        $domain->setCode('025')
            ->setLabel('Odontologie');
        $this->addStructures($domain, ['ME', 'MED', 'ODO']);
        $domains[] = $domain;

        // Pharmacie
        $domain = new Domain();
        $domain->setCode('026')
            ->setLabel('Pharmacie');
        $this->addStructures($domain, ['ME', 'MED']);
        $domains[] = $domain;

        // Philosophie
        $domain = new Domain();
        $domain->setCode('027')
            ->setLabel('Philosophie');
        $this->addStructures($domain, ['LA', 'LAS']);
        $domains[] = $domain;

        // Physique
        $domain = new Domain();
        $domain->setCode('028')
            ->setLabel('Physique');
        $this->addStructures($domain, ['ST', 'PAS', 'SC', 'SCI', 'ESP', 'UFM']);
        $domains[] = $domain;

        // Psychologie
        $domain = new Domain();
        $domain->setCode('029')
            ->setLabel('Psychologie');
        $this->addStructures($domain, ['ST', 'PAS', 'LA', 'LAS']);
        $domains[] = $domain;

        // Sciences de la Terre
        $domain = new Domain();
        $domain->setCode('030')
            ->setLabel('Sciences de la Terre');
        $this->addStructures($domain, ['SC', 'SCI']);
        $domains[] = $domain;

        // Sciences de la Communication
        $domain = new Domain();
        $domain->setCode('031')
            ->setLabel('Sciences de la Communication');
        $this->addStructures($domain, ['LA', 'LAS']);
        $domains[] = $domain;

        // Sciences de l'Education
        $domain = new Domain();
        $domain->setCode('032')
            ->setLabel('Sciences de l\'Education');
        $this->addStructures($domain, ['UFM', 'ESP']);
        $domains[] = $domain;

        // Sciences de l'Homme
        $domain = new Domain();
        $domain->setCode('033')
            ->setLabel('Sciences de l\'Homme');
        $this->addStructures($domain, ['LA', 'LAS']);
        $domains[] = $domain;

        // Sciences de l'Ingénieur
        $domain = new Domain();
        $domain->setCode('034')
            ->setLabel('Sciences de l\'Ingénieur');
        $this->addStructures($domain, ['EP', 'EPU']);
        $domains[] = $domain;

        // Sciences du Langage
        $domain = new Domain();
        $domain->setCode('035')
            ->setLabel('Sciences du Langage');
        $this->addStructures($domain, ['LA', 'LAS']);
        $domains[] = $domain;

        // Sciences du Sport
        $domain = new Domain();
        $domain->setCode('036')
            ->setLabel('Sciences du Sport');
        $this->addStructures($domain, ['ST', 'PAS', 'UFM', 'ESP']);
        $domains[] = $domain;

        // Sciences Politiques
        $domain = new Domain();
        $domain->setCode('037')
            ->setLabel('Sciences Politiques');
        $this->addStructures($domain, ['DRT', 'DR', 'IDP']);
        $domains[] = $domain;

        // Sociologie
        $domain = new Domain();
        $domain->setCode('038')
            ->setLabel('Sociologie');
        $this->addStructures($domain, ['ST', 'PAS', 'LA', 'LAS', 'DR', 'DRT']);
        $domains[] = $domain;

        return $domains;
    }

    /**
     * @param Domain $domain
     * @param array $codes
     */
    private function addStructures(Domain $domain, array $codes)
    {
        $structures = [];
        foreach ($codes as $code)
        {
            if(array_key_exists($code, $this->structures))
            {
                $structures[] = $this->structures[$code];
            }
        }
        $domain->setStructures(new ArrayCollection($structures));
    }

}