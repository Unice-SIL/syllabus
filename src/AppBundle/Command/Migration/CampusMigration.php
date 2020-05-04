<?php


namespace AppBundle\Command\Migration;


use AppBundle\Entity\Campus;

/**
 * Class CampusMigration
 * @package AppBundle\Command\Migration
 */
class CampusMigration extends AbstractReferentialMigration
{

    protected static $defaultName = 'app:campus-migration';

    /**
     * @return string
     */
    protected function getStartMessage(): string
    {
        return 'Start of campuses creation';
    }

    /**
     * @return string
     */
    protected function getEndMessage(): string
    {
        return 'End of campuses creation';
    }

    /**
     * @return string
     */
    protected function getEntityClassName(): string
    {
        return Campus::class;
    }

    /**
     * @return array
     */
    protected function getEntities(): array
    {
        $campuses = [];

        // CANNES
        $fabron = new Campus();
        $fabron->setCode('CANNES')
            ->setLabel("Cannes");
        $campuses[] = $fabron;

        // CARLONE
        $carlone = new Campus();
        $carlone->setCode('CARLONE')
            ->setLabel('Carlone');
        $campuses[] = $carlone;

        // FABRON
        $fabron = new Campus();
        $fabron->setCode('FABRON')
            ->setLabel("Fabron");
        $campuses[] = $fabron;

        // GEORGES V
        $georgesv = new Campus();
        $georgesv->setCode('GEORGESV')
            ->setLabel("Georges V");
        $campuses[] = $georgesv;

        // MENTON
        $menton = new Campus();
        $menton->setCode('MENTON')
            ->setLabel("Menton");
        $campuses[] = $menton;

        // PASTEUR
        $pasteur = new Campus();
        $pasteur->setCode('PASTEUR')
            ->setLabel("Pasteur");
        $campuses[] = $pasteur;

        // SOPHIA-ANTIPOLIS
        $sophia = new Campus();
        $sophia->setCode('SOPHIA')
            ->setLabel("Sophia-Antipolis");
        $campuses[] = $sophia;

        // ST JEAN D'ANGELY
        $sja = new Campus();
        $sja->setCode('SJA')
            ->setLabel("St Jean d'Angély");
        $campuses[] = $sja;

        // STAPS
        $staps = new Campus();
        $staps->setCode('STAPS')
            ->setLabel("Faculté des Sports");
        $campuses[] = $staps;

        // TROTABAS
        $trotabas = new Campus();
        $trotabas->setCode('TROTABAS')
            ->setLabel('Trotabas');
        $campuses[] = $trotabas;

        // VALROSE
        $valrose = new Campus();
        $valrose->setCode('VALROSE')
            ->setLabel('Valrose');
        $campuses[] = $valrose;


        return $campuses;
    }

}