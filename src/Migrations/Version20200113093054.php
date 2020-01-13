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
                            VALUES (\'structure_id\', \'structure_id\'), (\'title\', \'title\'), (\'ects\', \'ects\'), (\'level\', \'level\'), (\'languages\', \'languages\'), (\'domain\', \'domain\'), (\'semester\', \'semester\'), (\'summary\', \'summary\'),
                             (\'period\', \'period\'), (\'media_type\', \'media_type\'), (\'image\', \'image\'), (\'video\', \'video\'), (\'teaching_mode\', \'teaching_mode\'), (\'teaching_cm_class\', \'teaching_cm_class\'),
                             (\'teaching_td_class\', \'teaching_td_class\'), (\'teaching_tp_class\', \'teaching_tp_class\'), (\'teaching_other_class\', \'teaching_other_class\'), (\'teaching_other_type_class\', \'teaching_other_type_class\'),
                             (\'teaching_cm_hybrid_class\', \'teaching_cm_hybrid_class\'), (\'teaching_td_hybrid_class\', \'teaching_td_hybrid_class\'), (\'teaching_tp_hybrid_class\', \'teaching_tp_hybrid_class\'), 
                             (\'teaching_other_hybrid_class\', \'teaching_other_hybrid_class\'),
                             (\'teaching_other_type_hybrid_class\', \'teaching_other_type_hybrid_class\'), (\'teaching_cm_hybrid_dist\', \'teaching_cm_hybrid_dist\'), (\'teaching_td_hybrid_dist\', \'teaching_td_hybrid_dist\'), 
                             (\'teaching_other_hybrid_dist\', \'teaching_other_hybrid_dist\'), (\'teaching_other_type_hybrid_distant\', \'teaching_other_type_hybrid_distant\'), (\'mcc_weight\', \'mcc_weight\'), (\'mcc_compensable\', \'mcc_compensable\'), 
                             (\'mcc_capitalizable\', \'mcc_capitalizable\'),
                             (\'mcc_cc_coeff_session_1\', \'mcc_cc_coeff_session_1\'),(\'mcc_cc_nb_eval_session_1\', \'mcc_cc_nb_eval_session_1\'), (\'mcc_ct_coeff_session_1\', \'mcc_ct_coeff_session_1\'), (\'mcc_ct_nat_session_1\', \'mcc_ct_nat_session_1\'), 
                             (\'mcc_ct_duration_session_1\', \'mcc_ct_duration_session_1\'), (\'mcc_ct_coeff_session_2\', \'mcc_ct_coeff_session_2\'), (\'mcc_ct_nat_session_2\', \'mcc_ct_nat_session_2\'), 
                             (\'mcc_ct_duration_session_2\', \'mcc_ct_duration_session_2\'),
                             (\'mcc_advice\', \'mcc_advice\'), (\'tutoring\', \'tutoring\'), (\'tutoring_teacher\', \'tutoring_teacher\'), (\'tutoring_student\', \'tutoring_student\'), (\'tutoring_description\', \'tutoring_description\'), 
                             (\'educational_resources\', \'educational_resources\'), (\'bibliographic_resources\', \'bibliographic_resources\'), (\'agenda\', \'agenda\'), (\'organization\', \'organization\'), (\'closing_remarks\', \'closing_remarks\'), 
                             (\'closing_video\', \'closing_video\');');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE syllabus_duplication_field');
    }
}
