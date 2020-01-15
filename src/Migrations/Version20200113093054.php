<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200113093054 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE course_info_field (id INT AUTO_INCREMENT NOT NULL, field VARCHAR(150) NOT NULL, label VARCHAR(150) NOT NULL, manually_duplication TINYINT(1) DEFAULT \'0\' NOT NULL, UNIQUE INDEX UNIQ_725585DC5BF54558 (field), UNIQUE INDEX UNIQ_725585DCEA750E8 (label), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('INSERT INTO course_info_field (field, label) 
                            VALUES (\'structure\', \'Structure\'), (\'title\', \'Titre\'), (\'ects\', \'Présentation / ECTS\'), (\'level\', \'Présentation / Niveau\'), (\'languages\', \'Présentation / Langages\'), (\'domain\', \'Présentation / Domaine\'), (\'semester\', \'Présentation / Semestre\'), (\'summary\', \'Présentation / Résumé\'),
                             (\'period\', \'Présentation / Période\'), (\'mediaType\', \'Présentation / Type média\'), (\'image\', \'Présentation / Média image\'), (\'video\', \'Présentation / Média vidéo\'), (\'teachingMode\', \'Présentation / Mode enseignement\'), (\'teachingCmClass\', \'Présentation / Volume CM (présentiel)\'),
                             (\'teachingTdClass\', \'Présentation / Volume TD (présentiel)\'), (\'teachingTpClass\', \'Présentation / Volume TP (présentiel)\'), (\'teachingOtherClass\', \'Présentation / Volume Autre (présentiel)\'), (\'teachingOtherTypeClass\', \'Présentation / Type volume Autre (présentiel)\'),
                             (\'teachingCmHybridClass\', \'Présentation / Volume CM (hybride/présentiel)\'), (\'teachingTdHybridClass\', \'Présentation / Volume TD (hybride/présentiel)\'), (\'teachingTpHybridClass\', \'Présentation / Volume TP (hybride/présentiel)\'), 
                             (\'teachingOtherHybridClass\', \'Présentation / Volume Autre (hybride/présentiel)\'),
                             (\'teachingOtherTypeHybridClass\', \'Présentation / Type volume Autre (hybride/présentiel)\'), (\'teachingCmHybridDist\', \'Présentation / Volume CM (hybride/à distance)\'), (\'teachingTdHybridDist\', \'Présentation / Volume TD (hybride/à distance)\'), 
                             (\'teaching_other_hybrid_dist\', \'Présentation / Volume Autre (hybride/à distance)\'), (\'teaching_other_type_hybrid_distant\', \'Présentation / Type volume Autre (hybride/à distance)\'), (\'mcc_weight\', \'MCC / Poids ECUE\'), (\'mcc_compensable\', \'MCC / UE compensable\'), 
                             (\'mccCapitalizable\', \'MCC / UE capitalizable\'),
                             (\'mccCcCoeffSession1\', \'MCC / Session 1 - coefficient CC\'),(\'mccCcNbEvalSession1\', \'MCC / Session 1 - nb évaluation(s)\'), (\'mccCtCoeffSession_1\', \'MCC / Session 1 - coefficient CT\'), (\'mccCtNatSession1\', \'MCC / Session 1 - nature CT\'), 
                             (\'mccCtDurationSession1\', \'MCC / Session 1 - durée CT\'), (\'mccCtCoeffSession2\', \'MCC / Session 2 - coefficient CT\'), (\'mccCtNatSession2\', \'MCC / Session 2 - nature CT \'), 
                             (\'mccCtDurationSession2\', \'MCC / Session 2 - durée CT\'),
                             (\'mccAdvice\', \'MCC / Précisions\'), (\'tutoring\', \'Objectifs / Tutorat\'), (\'tutoringTeacher\', \'Objectifs / Objectifs / Tutorat avec tuteur enseignant\'), (\'tutoringStudent\', \'Objectifs / Tutorat avec tuteur étudiant\'), (\'tutoringDescription\', \'Objectifs / Description tutorat\'), 
                             (\'educationalResources\', \'Matériel / Ressources pédagogiques\'), (\'bibliographicResources\', \'Matériel / Eléments bibiographiques\'), (\'agenda\', \'Matériel / Agenda\'), (\'organization\', \'Infos / Organisation\'), (\'closingRemarks\', \'Mot de la fin / Message\'), 
                             (\'closingVideo\', \'Mot de la fin / Vidéo\'), (\'courseTeachers\', \'Présentation / Equipe enseignante\'), (\'courseSections\', \'Contenu & Activités / Sections\'), (\'courseEvaluationCts\', \'Contenu & Activités / Evaluations CT\'), (\'courseAchievements\', \'Objectifs / Acquis apprentissage\'),
                             (\'coursePrerequisites\', \'Objectifs / Prérequis\'), (\'courseTutoringResources\', \'Objectifs / Ressources tutorats\'), (\'courseResourceEquipments\', \'Matériel / Equipements\');');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE course_info_field');
    }
}
