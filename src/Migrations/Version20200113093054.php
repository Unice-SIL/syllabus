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

        $this->addSql('CREATE TABLE syllabus_duplication_field (id INT AUTO_INCREMENT NOT NULL, field VARCHAR(150) NOT NULL, label VARCHAR(150) NOT NULL, import TINYINT(1) DEFAULT \'0\' NOT NULL, UNIQUE INDEX UNIQ_725585DC5BF54558 (field), UNIQUE INDEX UNIQ_725585DCEA750E8 (label), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('INSERT INTO syllabus_duplication_field (field, label) 
                            VALUES (\'structure_id\', \'Structure\'), (\'title\', \'Titre\'), (\'ects\', \'Présentation / ECTS\'), (\'level\', \'Présentation / Niveau\'), (\'languages\', \'Présentation / Langages\'), (\'domain\', \'Présentation / Domaine\'), (\'semester\', \'Présentation / Semestre\'), (\'summary\', \'Présentation / Résumé\'),
                             (\'period\', \'Présentation / Période\'), (\'media_type\', \'Présentation / Type média\'), (\'image\', \'Présentation / Média image\'), (\'video\', \'Présentation / Média vidéo\'), (\'teaching_mode\', \'Présentation / Mode enseignement\'), (\'teaching_cm_class\', \'Présentation / Volume CM (présentiel)\'),
                             (\'teaching_td_class\', \'Présentation / Volume TD (présentiel)\'), (\'teaching_tp_class\', \'Présentation / Volume TP (présentiel)\'), (\'teaching_other_class\', \'Présentation / Volume Autre (présentiel)\'), (\'teaching_other_type_class\', \'Présentation / Type volume Autre (présentiel)\'),
                             (\'teaching_cm_hybrid_class\', \'Présentation / Volume CM (hybride/présentiel)\'), (\'teaching_td_hybrid_class\', \'Présentation / Volume TD (hybride/présentiel)\'), (\'teaching_tp_hybrid_class\', \'Présentation / Volume TP (hybride/présentiel)\'), 
                             (\'teaching_other_hybrid_class\', \'Présentation / Volume Autre (hybride/présentiel)\'),
                             (\'teaching_other_type_hybrid_class\', \'Présentation / Type volume Autre (hybride/présentiel)\'), (\'teaching_cm_hybrid_dist\', \'Présentation / Volume CM (hybride/à distance)\'), (\'teaching_td_hybrid_dist\', \'Présentation / Volume TD (hybride/à distance)\'), 
                             (\'teaching_other_hybrid_dist\', \'Présentation / Volume Autre (hybride/à distance)\'), (\'teaching_other_type_hybrid_distant\', \'Présentation / Type volume Autre (hybride/à distance)\'), (\'mcc_weight\', \'MCC / Poids ECUE\'), (\'mcc_compensable\', \'MCC / UE compensable\'), 
                             (\'mcc_capitalizable\', \'MCC / UE capitalizable\'),
                             (\'mcc_cc_coeff_session_1\', \'MCC / Session 1 - coefficient CC\'),(\'mcc_cc_nb_eval_session_1\', \'MCC / Session 1 - nb évaluation(s)\'), (\'mcc_ct_coeff_session_1\', \'MCC / Session 1 - coefficient CT\'), (\'mcc_ct_nat_session_1\', \'MCC / Session 1 - nature CT\'), 
                             (\'mcc_ct_duration_session_1\', \'MCC / Session 1 - durée CT\'), (\'mcc_ct_coeff_session_2\', \'MCC / Session 2 - coefficient CT\'), (\'mcc_ct_nat_session_2\', \'MCC / Session 2 - nature CT \'), 
                             (\'mcc_ct_duration_session_2\', \'MCC / Session 2 - durée CT\'),
                             (\'mcc_advice\', \'MCC / Précisions\'), (\'tutoring\', \'Objectifs / Tutorat\'), (\'tutoring_teacher\', \'Objectifs / Objectifs / Tutorat avec tuteur enseignant\'), (\'tutoring_student\', \'Objectifs / Tutorat avec tuteur étudiant\'), (\'tutoring_description\', \'Objectifs / Description tutorat\'), 
                             (\'educational_resources\', \'Matériel / Ressources pédagogiques\'), (\'bibliographic_resources\', \'Matériel / Eléments bibiographiques\'), (\'agenda\', \'Matériel / Agenda\'), (\'organization\', \'Infos / Organisation\'), (\'closing_remarks\', \'Mot de la fin / Message\'), 
                             (\'closing_video\', \'Mot de la fin / Vidéo\');');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE syllabus_duplication_field');
    }
}
