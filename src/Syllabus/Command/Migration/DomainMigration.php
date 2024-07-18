<?php


namespace App\Syllabus\Command\Migration;


use App\Syllabus\Entity\Domain;
use App\Syllabus\Entity\Structure;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Console\Attribute\AsCommand;

/**
 * Class DomainMigration
 * @package App\Syllabus\Command\Migration
 */
#[AsCommand(
    name: 'app:domain-migration',
)]
class DomainMigration extends AbstractReferentialMigration
{
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
        $structures = $this->em->getRepository(Structure::class)->findAll();

        $structuresEpu = new ArrayCollection(array_filter($structures, function(Structure $structure){
            return ($structure->getCode() === 'EPU' || $structure->getCode() === 'EP') ? true : false;
        }));
        $allStructuresWithoutEpu = new ArrayCollection(array_diff($structures, $structuresEpu->toArray()));

        $groups = [
            'Droit' => 'Droit privé et sciences criminelles',
            'Lettres' => 'Lettres et sciences humaines',
            'Medecine' => 'Médecine',
            'Odontologie' => 'Odontologie',
            'Pluridisciplinaire' => 'Pluridisciplinaire',
            'Polytech' => 'Polytech',
            'Sciences' => 'Sciences'
        ];
        $domains = [];

        // 01
        $domain = new Domain();
        $domain->setCode('01')
            ->setLabel('Droit privé et sciences criminelles')
            ->setGrp($groups['Droit'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 02
        $domain = new Domain();
        $domain->setCode('02')
            ->setLabel('Droit public')
            ->setGrp($groups['Droit'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 03
        $domain = new Domain();
        $domain->setCode('03')
            ->setLabel('Histoire du droit et des institutions')
            ->setGrp($groups['Droit'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 04
        $domain = new Domain();
        $domain->setCode('04')
            ->setLabel('Science politique')
            ->setGrp($groups['Droit'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 05
        $domain = new Domain();
        $domain->setCode('05')
            ->setLabel('Sciences économiques')
            ->setGrp($groups['Droit'])
        ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 06
        $domain = new Domain();
        $domain->setCode('06')
            ->setLabel('Sciences de gestion et du management')
            ->setGrp($groups['Droit'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 07
        $domain = new Domain();
        $domain->setCode('06')
            ->setLabel('Sciences du langage')
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 08
        $domain = new Domain();
        $domain->setCode('08')
            ->setLabel('Langues et littératures anciennes')
            ->setGrp($groups['Lettres'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 09
        $domain = new Domain();
        $domain->setCode('09')
            ->setLabel('Langue et littérature française')
            ->setGrp($groups['Lettres'])
        ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 10
        $domain = new Domain();
        $domain->setCode('10')
            ->setLabel('Littératures comparées')
            ->setGrp($groups['Lettres'])
        ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 11
        $domain = new Domain();
        $domain->setCode('11')
            ->setLabel('Études anglophones')
            ->setGrp($groups['Lettres'])
        ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 12
        $domain = new Domain();
        $domain->setCode('12')
            ->setLabel('Études germaniques et scandinaves')
            ->setGrp($groups['Lettres'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 13
        $domain = new Domain();
        $domain->setCode('13')
            ->setLabel('Études slaves et baltes')
            ->setGrp($groups['Lettres'])
        ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 14
        $domain = new Domain();
        $domain->setCode('14')
            ->setLabel('Études romanes')
            ->setGrp($groups['Lettres'])
        ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 15
        $domain = new Domain();
        $domain->setCode('15')
            ->setLabel('Langues, littératures et cultures africaines, asiatiques et d\'autres aires linguistiques')
            ->setGrp($groups['Lettres'])
        ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 16
        $domain = new Domain();
        $domain->setCode('16')
            ->setLabel('Psychologie et ergonomie')
            ->setGrp($groups['Lettres'])
        ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 17
        $domain = new Domain();
        $domain->setCode('17')
            ->setLabel('Philosophie')
            ->setGrp($groups['Lettres'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 18
        $domain = new Domain();
        $domain->setCode('18')
            ->setLabel('Architecture (ses théories et ses pratiques), arts appliqués, arts plastiques, arts du spectacle, épistémologie des enseignements artistiques, esthétique, musicologie, musique, sciences de l\'art')
            ->setGrp($groups['Lettres'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 19
        $domain = new Domain();
        $domain->setCode('19')
            ->setLabel('Sociologie, démographie')
            ->setGrp($groups['Lettres'])
        ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 20
        $domain = new Domain();
        $domain->setCode('20')
            ->setLabel('Ethnologie, préhistoire, anthropologie biologique')
            ->setGrp($groups['Lettres'])
        ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 21
        $domain = new Domain();
        $domain->setCode('21')
            ->setLabel('Histoire, civilisations, archéologie et art des mondes anciens et médiévaux')
            ->setGrp($groups['Lettres'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 22
        $domain = new Domain();
        $domain->setCode('22')
            ->setLabel('Histoire et civilisations : histoire des mondes modernes, histoire du monde contemporain ; de l\'art ; de la musique')
            ->setGrp($groups['Lettres'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 23
        $domain = new Domain();
        $domain->setCode('23')
            ->setLabel('Géographie physique, humaine, économique et régionale')
            ->setGrp($groups['Lettres'])
        ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 24
        $domain = new Domain();
        $domain->setCode('24')
            ->setLabel('Aménagement de l\'espace, urbanisme')
            ->setGrp($groups['Lettres'])
        ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 25
        $domain = new Domain();
        $domain->setCode('25')
            ->setLabel('Mathématiques')
            ->setGrp($groups['Sciences'])
        ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 26
        $domain = new Domain();
        $domain->setCode('26')
            ->setLabel('Mathématiques appliquées et applications des mathématiques')
            ->setGrp($groups['Sciences'])
        ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 27
        $domain = new Domain();
        $domain->setCode('27')
            ->setLabel('Informatique')
            ->setGrp($groups['Sciences'])
        ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 28
        $domain = new Domain();
        $domain->setCode('28')
            ->setLabel('Milieux denses et matériaux')
            ->setGrp($groups['Sciences'])
        ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 29
        $domain = new Domain();
        $domain->setCode('29')
            ->setLabel('Constituants élémentaires')
            ->setGrp($groups['Sciences'])
        ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 30
        $domain = new Domain();
        $domain->setCode('30')
            ->setLabel('Milieux dilués et optique')
            ->setGrp($groups['Sciences'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 31
        $domain = new Domain();
        $domain->setCode('31')
            ->setLabel('Chimie théorique, physique, analytique')
            ->setGrp($groups['Sciences'])
        ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 32
        $domain = new Domain();
        $domain->setCode('32')
            ->setLabel('Chimie organique, minérale, industrielle')
            ->setGrp($groups['Sciences'])
        ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 33
        $domain = new Domain();
        $domain->setCode('33')
            ->setLabel('Chimie des matériaux')
            ->setGrp($groups['Sciences'])
        ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 34
        $domain = new Domain();
        $domain->setCode('34')
            ->setLabel('Astronomie, astrophysique')
            ->setGrp($groups['Sciences'])
        ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 35
        $domain = new Domain();
        $domain->setCode('35')
            ->setLabel('Structure et évolution de la terre et des autres planètes')
            ->setGrp($groups['Sciences'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 36
        $domain = new Domain();
        $domain->setCode('36')
            ->setLabel('Terre solide : géodynamique des enveloppes supérieure, paléobiosphère')
            ->setGrp($groups['Sciences'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 37
        $domain = new Domain();
        $domain->setCode('37')
            ->setLabel('Météorologie, océanographie physique et physique de l\'environnement')
            ->setGrp($groups['Sciences'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 42
        $domain = new Domain();
        $domain->setCode('42')
            ->setLabel('Morphologie et morphogenèse')
            ->setGrp($groups['Medecine'])
            ->setGrp($groups['Medecine'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 43
        $domain = new Domain();
        $domain->setCode('43')
            ->setLabel('Biophysique et imagerie Médecin')
            ->setGrp($groups['Medecine'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 44
        $domain = new Domain();
        $domain->setCode('44')
            ->setLabel('Biochimie, biologie cellulaire et moléculaire, physiologie et nutrition')
            ->setGrp($groups['Medecine'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 45
        $domain = new Domain();
        $domain->setCode('45')
            ->setLabel('Microbiologie, maladies transmissibles et hygiène')
            ->setGrp($groups['Medecine'])
        ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 46
        $domain = new Domain();
        $domain->setCode('46')
            ->setLabel('Santé publique, environnement et société')
            ->setGrp($groups['Medecine'])
        ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 47
        $domain = new Domain();
        $domain->setCode('47')
            ->setLabel('Cancérologie, génétique, hématologie, immunologie')
            ->setGrp($groups['Medecine'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 48
        $domain = new Domain();
        $domain->setCode('48')
            ->setLabel('Anesthésiologie, réanimation, médecine d\'urgence, pharmacologie et thérapeutique')
            ->setGrp($groups['Medecine'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 49
        $domain = new Domain();
        $domain->setCode('49')
            ->setLabel('Pathologie nerveuse et musculaire, pathologie mentale, handicap et rééducation')
            ->setGrp($groups['Medecine'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 50
        $domain = new Domain();
        $domain->setCode('50')
            ->setLabel('Pathologie ostéo-articulaire, dermatologie et chirurgie plastique')
            ->setGrp($groups['Medecine'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 51
        $domain = new Domain();
        $domain->setCode('51')
            ->setLabel('Pathologie cardiorespiratoire et vasculaire')
            ->setGrp($groups['Medecine'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 52
        $domain = new Domain();
        $domain->setCode('52')
            ->setLabel('Maladies des appareils digestif et urinaire')
            ->setGrp($groups['Medecine'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 53
        $domain = new Domain();
        $domain->setCode('53')
            ->setLabel('Médecine interne, gériatrie et chirurgie générale')
            ->setGrp($groups['Medecine'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 54
        $domain = new Domain();
        $domain->setCode('54')
            ->setLabel('Développement et pathologie de l\'enfant, gynécologie-obstétrique, endocrinologie et reproduction')
            ->setGrp($groups['Medecine'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 55
        $domain = new Domain();
        $domain->setCode('55')
            ->setLabel('Pathologie de la tête et du cou')
            ->setGrp($groups['Medecine'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 56
        $domain = new Domain();
        $domain->setCode('56')
            ->setLabel('Développement, croissance et prévention')
            ->setGrp($groups['Odontologie'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 57
        $domain = new Domain();
        $domain->setCode('57')
            ->setLabel('Chirurgie orale ; parondontologie ; biologie orale')
            ->setGrp($groups['Odontologie'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 58
        $domain = new Domain();
        $domain->setCode('58')
            ->setLabel('Réhabilitation orale')
            ->setGrp($groups['Odontologie'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 60
        $domain = new Domain();
        $domain->setCode('60')
            ->setLabel('Mécanique, génie mécanique, génie civil')
            ->setGrp($groups['Sciences'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 61
        $domain = new Domain();
        $domain->setCode('61')
            ->setLabel('Génie informatique, automatique et traitement du signal')
            ->setGrp($groups['Sciences'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 62
        $domain = new Domain();
        $domain->setCode('62')
            ->setLabel('Energétique, génie des procédés')
            ->setGrp($groups['Sciences'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 63
        $domain = new Domain();
        $domain->setCode('63')
            ->setLabel('Génie électrique, électronique, photonique et systèmes')
            ->setGrp($groups['Sciences'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 64
        $domain = new Domain();
        $domain->setCode('64')
            ->setLabel('Biochimie et biologie moléculaire')
            ->setGrp($groups['Sciences'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 65
        $domain = new Domain();
        $domain->setCode('65')
            ->setLabel('Biologie cellulaire')
            ->setGrp($groups['Sciences'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 66
        $domain = new Domain();
        $domain->setCode('66')
            ->setLabel('Physiologie')
            ->setGrp($groups['Sciences'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 67
        $domain = new Domain();
        $domain->setCode('67')
            ->setLabel('Biologie des populations et écologie')
            ->setGrp($groups['Sciences'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 68
        $domain = new Domain();
        $domain->setCode('68')
            ->setLabel('Biologie des organismes')
            ->setGrp($groups['Sciences'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 69
        $domain = new Domain();
        $domain->setCode('69')
            ->setLabel('Neurosciences')
            ->setGrp($groups['Sciences'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 70
        $domain = new Domain();
        $domain->setCode('70')
            ->setLabel('Sciences de l\'éducation et de la formation')
            ->setGrp($groups['Pluridisciplinaire'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 71
        $domain = new Domain();
        $domain->setCode('71')
            ->setLabel('Sciences de l\'information et de la communication')
            ->setGrp($groups['Pluridisciplinaire'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 72
        $domain = new Domain();
        $domain->setCode('72')
            ->setLabel('Epistémologie, histoire des sciences et des techniques')
            ->setGrp($groups['Pluridisciplinaire'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 73
        $domain = new Domain();
        $domain->setCode('73')
            ->setLabel('Cultures et langues régionales')
            ->setGrp($groups['Pluridisciplinaire'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;

        // 74
        $domain = new Domain();
        $domain->setCode('74')
            ->setLabel('Sciences et techniques des activités physiques et sportives')
            ->setGrp($groups['Pluridisciplinaire'])
            ->setStructures($allStructuresWithoutEpu);
        $domains[] = $domain;


        // EPU01
        $domain = new Domain();
        $domain->setCode('EPU01')
            ->setLabel('Expression et communication')
            ->setGrp($groups['Polytech'])
            ->setStructures($structuresEpu);
        $domains[] = $domain;

        // EPU02
        $domain = new Domain();
        $domain->setCode('EPU02')
            ->setLabel('Questionner - Créer - Organiser – Manager')
            ->setGrp($groups['Polytech'])
            ->setStructures($structuresEpu);
        $domains[] = $domain;

        // EPU03
        $domain = new Domain();
        $domain->setCode('EPU03')
            ->setLabel('Techniques et méthodes')
            ->setGrp($groups['Polytech'])
            ->setStructures($structuresEpu);
        $domains[] = $domain;

        // EPU04
        $domain = new Domain();
        $domain->setCode('EPU04')
            ->setLabel('Connaissances scientifiques')
            ->setGrp($groups['Polytech'])
            ->setStructures($structuresEpu);
        $domains[] = $domain;

        // EPU05
        $domain = new Domain();
        $domain->setCode('EPU05')
            ->setLabel('Stages, projets, périodes de travail à l’extérieur ')
            ->setGrp($groups['Polytech'])
            ->setStructures($structuresEpu);
        $domains[] = $domain;

        return $domains;
    }

}