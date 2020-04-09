<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200109101223 extends AbstractMigration
{

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE activity (id CHAR(36) NOT NULL, `label` VARCHAR(100) NOT NULL, label_visibility TINYINT(1) NOT NULL COMMENT \'Témoin affichage de l\'\'intitulé de l\'\'activité\', type VARCHAR(25) NOT NULL, mode VARCHAR(25) NOT NULL, grp VARCHAR(25) DEFAULT NULL, obsolete TINYINT(1) NOT NULL, ord INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course (id CHAR(36) NOT NULL, type CHAR(5) NOT NULL, etb_id CHAR(36) NOT NULL, UNIQUE INDEX etb_id_UNIQUE (etb_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_hierarchy (course_child_id CHAR(36) NOT NULL, course_parent_id CHAR(36) NOT NULL, INDEX IDX_78DB680274D6AF4D (course_child_id), INDEX IDX_78DB6802F0DB8ADC (course_parent_id), PRIMARY KEY(course_child_id, course_parent_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_achievement (id CHAR(36) NOT NULL, course_info_id CHAR(36) NOT NULL, description TEXT DEFAULT NULL, ord INT NOT NULL, INDEX fk_course_achievement_course_info1_idx (course_info_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_domain (id CHAR(36) NOT NULL, course_info_id CHAR(36) NOT NULL, domain VARCHAR(255) DEFAULT NULL, INDEX fk_course_domain_course_info1_idx (course_info_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_evaluation_ct (id CHAR(36) NOT NULL, activity_id CHAR(36) NOT NULL, course_info_id CHAR(36) NOT NULL, description VARCHAR(255) DEFAULT NULL, evaluation_rate DOUBLE PRECISION DEFAULT NULL, ord INT NOT NULL, INDEX fk_course_evaluation_ct_course_info1_idx (course_info_id), INDEX fk_course_evaluation_ct_activity1_idx (activity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_info (id CHAR(36) NOT NULL, course_id CHAR(36) NOT NULL, structure_id CHAR(36) NOT NULL, last_updater CHAR(36) DEFAULT NULL, publisher CHAR(36) DEFAULT NULL, year_id CHAR(4) NOT NULL, title VARCHAR(200) NOT NULL, ects DOUBLE PRECISION DEFAULT NULL, level CHAR(15) DEFAULT NULL, languages VARCHAR(200) DEFAULT NULL, domain CHAR(100) DEFAULT NULL, semester INT DEFAULT NULL, summary TEXT DEFAULT NULL, period VARCHAR(255) DEFAULT NULL, media_type VARCHAR(10) DEFAULT NULL, image TEXT DEFAULT NULL, video TEXT DEFAULT NULL, teaching_mode CHAR(15) DEFAULT NULL, teaching_cm_class DOUBLE PRECISION DEFAULT NULL, teaching_td_class DOUBLE PRECISION DEFAULT NULL, teaching_tp_class DOUBLE PRECISION DEFAULT NULL, teaching_other_class DOUBLE PRECISION DEFAULT NULL, teaching_other_type_class VARCHAR(65) DEFAULT NULL, teaching_cm_hybrid_class DOUBLE PRECISION DEFAULT NULL, teaching_td_hybrid_class DOUBLE PRECISION DEFAULT NULL, teaching_tp_hybrid_class DOUBLE PRECISION DEFAULT NULL, teaching_other_hybrid_class DOUBLE PRECISION DEFAULT NULL, teaching_other_type_hybrid_class VARCHAR(65) DEFAULT NULL, teaching_cm_hybrid_dist DOUBLE PRECISION DEFAULT NULL, teaching_td_hybrid_dist DOUBLE PRECISION DEFAULT NULL, teaching_other_hybrid_dist DOUBLE PRECISION DEFAULT NULL, teaching_other_type_hybrid_distant VARCHAR(65) DEFAULT NULL, mcc_weight DOUBLE PRECISION DEFAULT NULL, mcc_compensable TINYINT(1) NOT NULL, mcc_capitalizable TINYINT(1) NOT NULL, mcc_cc_coeff_session_1 DOUBLE PRECISION DEFAULT NULL, mcc_cc_nb_eval_session_1 INT DEFAULT NULL, mcc_ct_coeff_session_1 DOUBLE PRECISION DEFAULT NULL, mcc_ct_nat_session_1 VARCHAR(100) DEFAULT NULL, mcc_ct_duration_session_1 VARCHAR(100) DEFAULT NULL, mcc_ct_coeff_session_2 DOUBLE PRECISION DEFAULT NULL, mcc_ct_nat_session_2 VARCHAR(100) DEFAULT NULL, mcc_ct_duration_session_2 VARCHAR(100) DEFAULT NULL, mcc_advice TEXT DEFAULT NULL, tutoring TINYINT(1) NOT NULL, tutoring_teacher TINYINT(1) NOT NULL, tutoring_student TINYINT(1) NOT NULL, tutoring_description TEXT DEFAULT NULL, educational_resources TEXT DEFAULT NULL, bibliographic_resources TEXT DEFAULT NULL, agenda TEXT DEFAULT NULL, organization TEXT DEFAULT NULL, closing_remarks TEXT DEFAULT NULL, closing_video TEXT DEFAULT NULL, creation_date DATETIME NOT NULL, modification_date DATETIME DEFAULT NULL, publication_date DATETIME DEFAULT NULL, tem_presentation_tab_valid TINYINT(1) NOT NULL, tem_activities_tab_valid TINYINT(1) NOT NULL, tem_objectives_tab_valid TINYINT(1) NOT NULL, tem_mcc_tab_valid TINYINT(1) NOT NULL, tem_equipments_tab_valid TINYINT(1) NOT NULL, tem_infos_tab_valid TINYINT(1) NOT NULL, tem_closing_remarks_tab_valid TINYINT(1) NOT NULL, INDEX fk_course_info_user2_idx (publisher), INDEX fk_course_info_course1_idx (course_id), INDEX fk_course_info_structure1_idx (structure_id), INDEX fk_course_info_user1_idx (last_updater), INDEX fk_course_info_year1_idx (year_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_permission (id CHAR(36) NOT NULL, course_info_id CHAR(36) NOT NULL, user_id CHAR(36) NOT NULL, permission CHAR(45) NOT NULL, INDEX fk_course_permission_course_info1_idx (course_info_id), INDEX fk_course_permission_user1_idx (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_prerequisite (id CHAR(36) NOT NULL, course_info_id CHAR(36) NOT NULL, description TEXT DEFAULT NULL, ord INT NOT NULL, INDEX fk_course_prerequisite_course_info1_idx (course_info_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_resource_equipment (id CHAR(36) NOT NULL, course_info_id CHAR(36) NOT NULL, equipment_id CHAR(36) NOT NULL, description VARCHAR(255) DEFAULT NULL, ord INT NOT NULL, INDEX fk_course_resource_equipment_course_info1_idx (course_info_id), INDEX fk_course_resource_equipment_equipment1_idx (equipment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_section (id CHAR(36) NOT NULL, course_info_id CHAR(36) NOT NULL, title VARCHAR(200) DEFAULT NULL, description TEXT DEFAULT NULL, ord INT NOT NULL, INDEX fk_course_section_course_info1_idx (course_info_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_section_activity (id CHAR(36) NOT NULL, activity_id CHAR(36) NOT NULL, course_section_id CHAR(36) NOT NULL, description VARCHAR(255) DEFAULT NULL, evaluation_rate DOUBLE PRECISION DEFAULT NULL, evaluation_teacher TINYINT(1) NOT NULL, evaluation_peer TINYINT(1) NOT NULL, ord INT NOT NULL, INDEX fk_course_section_activity_course_section1_idx (course_section_id), INDEX fk_course_section_activity_activity1_idx (activity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_teacher (id CHAR(36) NOT NULL, course_info_id CHAR(36) NOT NULL, firstname VARCHAR(100) DEFAULT NULL, lastname VARCHAR(100) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, manager TINYINT(1) NOT NULL, email_visibility TINYINT(1) NOT NULL, INDEX fk_course_teacher_course_info1_idx (course_info_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_tutoring_resource (id CHAR(36) NOT NULL, course_info_id CHAR(36) NOT NULL, description TEXT DEFAULT NULL, ord INT NOT NULL, INDEX fk_course_tutoring_resources_course_info1_idx (course_info_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipment (id CHAR(36) NOT NULL, `label` VARCHAR(100) NOT NULL, label_visibility TINYINT(1) NOT NULL, icon TEXT DEFAULT NULL, obsolete TINYINT(1) NOT NULL, ord INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE structure (id CHAR(36) NOT NULL, etbId VARCHAR(45) NOT NULL, `label` VARCHAR(100) DEFAULT NULL, campus VARCHAR(100) DEFAULT NULL, obsolete TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id CHAR(36) NOT NULL, username VARCHAR(255) DEFAULT NULL, firstname CHAR(100) DEFAULT NULL, lastname CHAR(100) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, salt VARCHAR(255) DEFAULT NULL, roles LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX username_UNIQUE (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE year (id CHAR(4) NOT NULL, `label` CHAR(45) DEFAULT NULL, import TINYINT(1) DEFAULT NULL, edit TINYINT(1) DEFAULT NULL, current TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course_hierarchy ADD CONSTRAINT FK_78DB680274D6AF4D FOREIGN KEY (course_child_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE course_hierarchy ADD CONSTRAINT FK_78DB6802F0DB8ADC FOREIGN KEY (course_parent_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE course_achievement ADD CONSTRAINT FK_E21D4F255548C414 FOREIGN KEY (course_info_id) REFERENCES course_info (id)');
        $this->addSql('ALTER TABLE course_domain ADD CONSTRAINT FK_991DF465548C414 FOREIGN KEY (course_info_id) REFERENCES course_info (id)');
        $this->addSql('ALTER TABLE course_evaluation_ct ADD CONSTRAINT FK_61B9EA7181C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
        $this->addSql('ALTER TABLE course_evaluation_ct ADD CONSTRAINT FK_61B9EA715548C414 FOREIGN KEY (course_info_id) REFERENCES course_info (id)');
        $this->addSql('ALTER TABLE course_info ADD CONSTRAINT FK_32BEC51591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE course_info ADD CONSTRAINT FK_32BEC512534008B FOREIGN KEY (structure_id) REFERENCES structure (id)');
        $this->addSql('ALTER TABLE course_info ADD CONSTRAINT FK_32BEC5154C31FEE FOREIGN KEY (last_updater) REFERENCES user (id)');
        $this->addSql('ALTER TABLE course_info ADD CONSTRAINT FK_32BEC519CE8D546 FOREIGN KEY (publisher) REFERENCES user (id)');
        $this->addSql('ALTER TABLE course_info ADD CONSTRAINT FK_32BEC5140C1FEA7 FOREIGN KEY (year_id) REFERENCES year (id)');
        $this->addSql('ALTER TABLE course_permission ADD CONSTRAINT FK_3FABDC295548C414 FOREIGN KEY (course_info_id) REFERENCES course_info (id)');
        $this->addSql('ALTER TABLE course_permission ADD CONSTRAINT FK_3FABDC29A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE course_prerequisite ADD CONSTRAINT FK_C45EDAC55548C414 FOREIGN KEY (course_info_id) REFERENCES course_info (id)');
        $this->addSql('ALTER TABLE course_resource_equipment ADD CONSTRAINT FK_E25858005548C414 FOREIGN KEY (course_info_id) REFERENCES course_info (id)');
        $this->addSql('ALTER TABLE course_resource_equipment ADD CONSTRAINT FK_E2585800517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id)');
        $this->addSql('ALTER TABLE course_section ADD CONSTRAINT FK_25B07F035548C414 FOREIGN KEY (course_info_id) REFERENCES course_info (id)');
        $this->addSql('ALTER TABLE course_section_activity ADD CONSTRAINT FK_B95D28E681C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
        $this->addSql('ALTER TABLE course_section_activity ADD CONSTRAINT FK_B95D28E67C1ADF9 FOREIGN KEY (course_section_id) REFERENCES course_section (id)');
        $this->addSql('ALTER TABLE course_teacher ADD CONSTRAINT FK_B835A3395548C414 FOREIGN KEY (course_info_id) REFERENCES course_info (id)');
        $this->addSql('ALTER TABLE course_tutoring_resource ADD CONSTRAINT FK_A718CCA45548C414 FOREIGN KEY (course_info_id) REFERENCES course_info (id)');
    }

    /**
     * @param Schema $schema
     * @throws DBALException
     */
    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE course_evaluation_ct DROP FOREIGN KEY FK_61B9EA7181C06096');
        $this->addSql('ALTER TABLE course_section_activity DROP FOREIGN KEY FK_B95D28E681C06096');
        $this->addSql('ALTER TABLE course_hierarchy DROP FOREIGN KEY FK_78DB680274D6AF4D');
        $this->addSql('ALTER TABLE course_hierarchy DROP FOREIGN KEY FK_78DB6802F0DB8ADC');
        $this->addSql('ALTER TABLE course_info DROP FOREIGN KEY FK_32BEC51591CC992');
        $this->addSql('ALTER TABLE course_achievement DROP FOREIGN KEY FK_E21D4F255548C414');
        $this->addSql('ALTER TABLE course_domain DROP FOREIGN KEY FK_991DF465548C414');
        $this->addSql('ALTER TABLE course_evaluation_ct DROP FOREIGN KEY FK_61B9EA715548C414');
        $this->addSql('ALTER TABLE course_permission DROP FOREIGN KEY FK_3FABDC295548C414');
        $this->addSql('ALTER TABLE course_prerequisite DROP FOREIGN KEY FK_C45EDAC55548C414');
        $this->addSql('ALTER TABLE course_resource_equipment DROP FOREIGN KEY FK_E25858005548C414');
        $this->addSql('ALTER TABLE course_section DROP FOREIGN KEY FK_25B07F035548C414');
        $this->addSql('ALTER TABLE course_teacher DROP FOREIGN KEY FK_B835A3395548C414');
        $this->addSql('ALTER TABLE course_tutoring_resource DROP FOREIGN KEY FK_A718CCA45548C414');
        $this->addSql('ALTER TABLE course_section_activity DROP FOREIGN KEY FK_B95D28E67C1ADF9');
        $this->addSql('ALTER TABLE course_resource_equipment DROP FOREIGN KEY FK_E2585800517FE9FE');
        $this->addSql('ALTER TABLE course_info DROP FOREIGN KEY FK_32BEC512534008B');
        $this->addSql('ALTER TABLE course_info DROP FOREIGN KEY FK_32BEC5154C31FEE');
        $this->addSql('ALTER TABLE course_info DROP FOREIGN KEY FK_32BEC519CE8D546');
        $this->addSql('ALTER TABLE course_permission DROP FOREIGN KEY FK_3FABDC29A76ED395');
        $this->addSql('ALTER TABLE course_info DROP FOREIGN KEY FK_32BEC5140C1FEA7');
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE course_hierarchy');
        $this->addSql('DROP TABLE course_achievement');
        $this->addSql('DROP TABLE course_domain');
        $this->addSql('DROP TABLE course_evaluation_ct');
        $this->addSql('DROP TABLE course_info');
        $this->addSql('DROP TABLE course_permission');
        $this->addSql('DROP TABLE course_prerequisite');
        $this->addSql('DROP TABLE course_resource_equipment');
        $this->addSql('DROP TABLE course_section');
        $this->addSql('DROP TABLE course_section_activity');
        $this->addSql('DROP TABLE course_teacher');
        $this->addSql('DROP TABLE course_tutoring_resource');
        $this->addSql('DROP TABLE equipment');
        $this->addSql('DROP TABLE structure');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE year');
    }
}
