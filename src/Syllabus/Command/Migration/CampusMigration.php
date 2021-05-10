<?php


namespace App\Syllabus\Command\Migration;


use App\Syllabus\Entity\Campus;

/**
 * Class CampusMigration
 * @package App\Syllabus\Command\Migration
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
        $campus = new Campus();
        $campus->setCode('CANNES')
            ->setLabel("Campus Cannes - Bastide Rouge");
        $campuses[] = $campus;

        // GRASSE
        $campus = new Campus();
        $campus->setCode('GRASSE')
            ->setLabel("Campus Grasse");
        $campuses[] = $campus;

        // MENTON
        $campus = new Campus();
        $campus->setCode('MENTON')
            ->setLabel("Campus Menton");
        $campuses[] = $campus;

        // CARLONE
        $campus = new Campus();
        $campus->setCode('CARLONE')
            ->setLabel('Campus Carlone');
        $campuses[] = $campus;

        // IMREDD
        $campus = new Campus();
        $campus->setCode('IMREDD')
            ->setLabel('Campus Ecovallée - IMREDD');
        $campuses[] = $campus;

        // FABRON
        $campus = new Campus();
        $campus->setCode('FABRON')
            ->setLabel("Campus Fabron");
        $campuses[] = $campus;

        // IFMK
        $campus = new Campus();
        $campus->setCode('IFMK')
            ->setLabel("Campus IFMK");
        $campuses[] = $campus;

        // LIEGEARD
        $campus = new Campus();
        $campus->setCode('LIEGEARD')
            ->setLabel("Campus Liégeard");
        $campuses[] = $campus;

        // PASTEUR
        $campus = new Campus();
        $campus->setCode('PASTEUR')
            ->setLabel("Campus Pasteur");
        $campuses[] = $campus;

        // ST JEAN D'ANGELY
        $campus = new Campus();
        $campus->setCode('SJA')
            ->setLabel("Campus Saint Jean d'Angély");
        $campuses[] = $campus;

        // STAPS
        $campus = new Campus();
        $campus->setCode('STAPS')
            ->setLabel("Campus Sciences du Sport - STAPS");
        $campuses[] = $campus;

        // TROTABAS
        $campus = new Campus();
        $campus->setCode('TROTABAS')
            ->setLabel('Campus Trotabas');
        $campuses[] = $campus;

        // VILLA ARSON
        $campus = new Campus();
        $campus->setCode('ARSON')
            ->setLabel('Campus Villa Arson');
        $campuses[] = $campus;

        // VALROSE
        $campus = new Campus();
        $campus->setCode('VALROSE')
            ->setLabel('Campus Valrose');
        $campuses[] = $campus;

        // SOPHIATECH
        $campus = new Campus();
        $campus->setCode('SOPHIATECH')
            ->setLabel('Campus SophiaTech Les Lucioles');
        $campuses[] = $campus;

        return $campuses;
    }

}