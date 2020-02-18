<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200127105326 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        // Drop old foreign keys
        $this->addSql('ALTER TABLE course_evaluation_ct DROP FOREIGN KEY FK_61B9EA7181C06096');
        $this->addSql('ALTER TABLE course_section_activity DROP FOREIGN KEY FK_B95D28E681C06096');
        $this->addSql('ALTER TABLE course_info DROP FOREIGN KEY FK_32BEC512534008B');
        $this->addSql('ALTER TABLE course_info DROP FOREIGN KEY FK_32BEC5140C1FEA7');
        $this->addSql('ALTER TABLE course_info DROP FOREIGN KEY FK_32BEC5154C31FEE');
        $this->addSql('ALTER TABLE course_info DROP FOREIGN KEY FK_32BEC51591CC992');
        $this->addSql('ALTER TABLE course_info DROP FOREIGN KEY FK_32BEC519CE8D546');
        $this->addSql('ALTER TABLE course_section DROP FOREIGN KEY FK_25B07F035548C414');
        $this->addSql('ALTER TABLE course_section_activity DROP FOREIGN KEY FK_B95D28E67C1ADF9');
        $this->addSql('ALTER TABLE course_resource_equipment DROP FOREIGN KEY FK_E2585800517FE9FE');
        $this->addSql('ALTER TABLE course_resource_equipment DROP FOREIGN KEY FK_E25858005548C414');
        $this->addSql('ALTER TABLE course_achievement DROP FOREIGN KEY FK_E21D4F255548C414');
        $this->addSql('ALTER TABLE course_prerequisite DROP FOREIGN KEY FK_C45EDAC55548C414');
        $this->addSql('ALTER TABLE course_tutoring_resource DROP FOREIGN KEY FK_A718CCA45548C414');
        $this->addSql('ALTER TABLE course_teacher DROP FOREIGN KEY FK_B835A3395548C414');
        $this->addSql('ALTER TABLE course_permission DROP FOREIGN KEY FK_3FABDC295548C414');
        $this->addSql('ALTER TABLE course_permission DROP FOREIGN KEY FK_3FABDC29A76ED395');

        // Drop old indexes
        $this->addSql('DROP INDEX fk_course_info_course1_idx ON course_info');
        $this->addSql('DROP INDEX fk_course_info_structure1_idx ON course_info');
        $this->addSql('DROP INDEX fk_course_info_user1_idx ON course_info');
        $this->addSql('DROP INDEX fk_course_info_user2_idx ON course_info');
        $this->addSql('DROP INDEX fk_course_info_year1_idx ON course_info');
        $this->addSql('DROP INDEX fk_course_section_course_info1_idx ON course_section');
        $this->addSql('DROP INDEX fk_course_resource_equipment_course_info1_idx ON course_resource_equipment');
        $this->addSql('DROP INDEX fk_course_resource_equipment_equipment1_idx ON course_resource_equipment');
        $this->addSql('DROP INDEX fk_course_achievement_course_info1_idx ON course_achievement');
        $this->addSql('DROP INDEX fk_course_prerequisite_course_info1_idx ON course_prerequisite');
        $this->addSql('DROP INDEX fk_course_tutoring_resources_course_info1_idx ON course_tutoring_resource');
        $this->addSql('DROP INDEX fk_course_teacher_course_info1_idx ON course_teacher');
        $this->addSql('DROP INDEX fk_course_permission_course_info1_idx ON course_permission');
        $this->addSql('DROP INDEX fk_course_permission_user1_idx ON course_permission');

        // Drop useless table
        $this->addSql('DROP TABLE course_domain');

        // Rename old tables to save data
        $this->addSql('ALTER TABLE activity RENAME TO bak_activity');
        $this->addSql('ALTER TABLE course_section_activity RENAME TO bak_course_section_activity');
        $this->addSql('ALTER TABLE course_evaluation_ct RENAME TO bak_course_evaluation_ct');


        // Create new tables
        $this->addSql('CREATE TABLE activity (id CHAR(36) NOT NULL, `label` VARCHAR(100) NOT NULL, description VARCHAR(200) DEFAULT NULL, label_visibility TINYINT(1) NOT NULL COMMENT \'Témoin affichage de l\'\'intitulé de l\'\'activité\', obsolete TINYINT(1) NOT NULL, position INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_section_activity (id CHAR(36) NOT NULL, activity_id CHAR(36) NOT NULL, activity_type_id CHAR(36) NOT NULL, activity_mode_id CHAR(36) NOT NULL, course_section_id CHAR(36) NOT NULL, description VARCHAR(255) DEFAULT NULL, evaluation_rate DOUBLE PRECISION DEFAULT NULL, evaluation_teacher TINYINT(1) NOT NULL, evaluation_peer TINYINT(1) NOT NULL, position INT NOT NULL, INDEX IDX_B95D28E681C06096 (activity_id), INDEX IDX_B95D28E6C51EFA73 (activity_type_id), INDEX IDX_B95D28E677B7F3AA (activity_mode_id), INDEX IDX_B95D28E67C1ADF9 (course_section_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE activity_mode (id CHAR(36) NOT NULL, `label` VARCHAR(100) NOT NULL, obsolete TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE activity_type (id CHAR(36) NOT NULL, `label` VARCHAR(100) NOT NULL, obsolete TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE activity_type_activity (activitytype_id CHAR(36) NOT NULL, activity_id CHAR(36) NOT NULL, INDEX IDX_6059E7626E098B10 (activitytype_id), INDEX IDX_6059E76281C06096 (activity_id), PRIMARY KEY(activitytype_id, activity_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE activity_type_activity_mode (activitytype_id CHAR(36) NOT NULL, activitymode_id CHAR(36) NOT NULL, INDEX IDX_642514846E098B10 (activitytype_id), INDEX IDX_64251484DCA082C9 (activitymode_id), PRIMARY KEY(activitytype_id, activitymode_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');

        // Rename fields
        $this->addSql('ALTER TABLE course_achievement CHANGE ord position INT NOT NULL');
        $this->addSql('ALTER TABLE course_prerequisite CHANGE ord position INT NOT NULL');
        $this->addSql('ALTER TABLE course_resource_equipment CHANGE ord position INT NOT NULL');
        $this->addSql('ALTER TABLE course_section CHANGE ord position INT NOT NULL');
        $this->addSql('ALTER TABLE course CHANGE etb_id code CHAR(36)');
        $this->addSql('ALTER TABLE structure CHANGE etbId code CHAR(36)');

        // Create new indexes
        $this->addSql('CREATE INDEX IDX_32BEC51591CC992 ON course_info (course_id)');
        $this->addSql('CREATE INDEX IDX_32BEC512534008B ON course_info (structure_id)');
        $this->addSql('CREATE INDEX IDX_32BEC5154C31FEE ON course_info (last_updater)');
        $this->addSql('CREATE INDEX IDX_32BEC519CE8D546 ON course_info (publisher)');
        $this->addSql('CREATE INDEX IDX_32BEC5140C1FEA7 ON course_info (year_id)');
        $this->addSql('CREATE INDEX IDX_25B07F035548C414 ON course_section (course_info_id)');
        $this->addSql('CREATE INDEX IDX_E25858005548C414 ON course_resource_equipment (course_info_id)');
        $this->addSql('CREATE INDEX IDX_E2585800517FE9FE ON course_resource_equipment (equipment_id)');
        $this->addSql('CREATE INDEX IDX_E21D4F255548C414 ON course_achievement (course_info_id)');
        $this->addSql('CREATE INDEX IDX_C45EDAC55548C414 ON course_prerequisite (course_info_id)');
        $this->addSql('CREATE INDEX IDX_A718CCA45548C414 ON course_tutoring_resource (course_info_id)');
        $this->addSql('CREATE INDEX IDX_B835A3395548C414 ON course_teacher (course_info_id)');
        $this->addSql('CREATE INDEX IDX_3FABDC295548C414 ON course_permission (course_info_id)');
        $this->addSql('CREATE INDEX IDX_3FABDC29A76ED395 ON course_permission (user_id)');

        // Create new foreign keys
        $this->addSql('ALTER TABLE course_section_activity ADD CONSTRAINT FK_B95D28E681C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
        $this->addSql('ALTER TABLE course_section_activity ADD CONSTRAINT FK_B95D28E6C51EFA73 FOREIGN KEY (activity_type_id) REFERENCES activity_type (id)');
        $this->addSql('ALTER TABLE course_section_activity ADD CONSTRAINT FK_B95D28E677B7F3AA FOREIGN KEY (activity_mode_id) REFERENCES activity_mode (id)');
        $this->addSql('ALTER TABLE course_section_activity ADD CONSTRAINT FK_B95D28E67C1ADF9 FOREIGN KEY (course_section_id) REFERENCES course_section (id)');
        $this->addSql('ALTER TABLE activity_type_activity ADD CONSTRAINT FK_6059E7626E098B10 FOREIGN KEY (activitytype_id) REFERENCES activity_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activity_type_activity ADD CONSTRAINT FK_6059E76281C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activity_type_activity_mode ADD CONSTRAINT FK_642514846E098B10 FOREIGN KEY (activitytype_id) REFERENCES activity_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activity_type_activity_mode ADD CONSTRAINT FK_64251484DCA082C9 FOREIGN KEY (activitymode_id) REFERENCES activity_mode (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_info ADD CONSTRAINT FK_32BEC512534008B FOREIGN KEY (structure_id) REFERENCES structure (id)');
        $this->addSql('ALTER TABLE course_info ADD CONSTRAINT FK_32BEC5140C1FEA7 FOREIGN KEY (year_id) REFERENCES year (id)');
        $this->addSql('ALTER TABLE course_info ADD CONSTRAINT FK_32BEC5154C31FEE FOREIGN KEY (last_updater) REFERENCES user (id)');
        $this->addSql('ALTER TABLE course_info ADD CONSTRAINT FK_32BEC51591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE course_info ADD CONSTRAINT FK_32BEC519CE8D546 FOREIGN KEY (publisher) REFERENCES user (id)');
        $this->addSql('ALTER TABLE course_section ADD CONSTRAINT FK_25B07F035548C414 FOREIGN KEY (course_info_id) REFERENCES course_info (id)');
        $this->addSql('ALTER TABLE course_resource_equipment ADD CONSTRAINT FK_E2585800517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id)');
        $this->addSql('ALTER TABLE course_resource_equipment ADD CONSTRAINT FK_E25858005548C414 FOREIGN KEY (course_info_id) REFERENCES course_info (id)');
        $this->addSql('ALTER TABLE course_achievement ADD CONSTRAINT FK_E21D4F255548C414 FOREIGN KEY (course_info_id) REFERENCES course_info (id)');
        $this->addSql('ALTER TABLE course_prerequisite ADD CONSTRAINT FK_C45EDAC55548C414 FOREIGN KEY (course_info_id) REFERENCES course_info (id)');
        $this->addSql('ALTER TABLE course_tutoring_resource ADD CONSTRAINT FK_A718CCA45548C414 FOREIGN KEY (course_info_id) REFERENCES course_info (id)');
        $this->addSql('ALTER TABLE course_teacher ADD CONSTRAINT FK_B835A3395548C414 FOREIGN KEY (course_info_id) REFERENCES course_info (id)');
        $this->addSql('ALTER TABLE course_permission ADD CONSTRAINT FK_3FABDC295548C414 FOREIGN KEY (course_info_id) REFERENCES course_info (id)');
        $this->addSql('ALTER TABLE course_permission ADD CONSTRAINT FK_3FABDC29A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        // Drop new foreign keys
        $this->addSql('ALTER TABLE course_section_activity DROP FOREIGN KEY FK_B95D28E681C06096');
        $this->addSql('ALTER TABLE course_section_activity DROP FOREIGN KEY FK_B95D28E6C51EFA73');
        $this->addSql('ALTER TABLE course_section_activity DROP FOREIGN KEY FK_B95D28E677B7F3AA');
        $this->addSql('ALTER TABLE activity_type_activity DROP FOREIGN KEY FK_6059E7626E098B10');
        $this->addSql('ALTER TABLE activity_type_activity DROP FOREIGN KEY FK_6059E76281C06096');
        $this->addSql('ALTER TABLE activity_type_activity_mode DROP FOREIGN KEY FK_642514846E098B10');
        $this->addSql('ALTER TABLE activity_type_activity_mode DROP FOREIGN KEY FK_64251484DCA082C9');
        $this->addSql('ALTER TABLE course_info DROP FOREIGN KEY FK_32BEC512534008B');
        $this->addSql('ALTER TABLE course_info DROP FOREIGN KEY FK_32BEC5140C1FEA7');
        $this->addSql('ALTER TABLE course_info DROP FOREIGN KEY FK_32BEC5154C31FEE');
        $this->addSql('ALTER TABLE course_info DROP FOREIGN KEY FK_32BEC51591CC992');
        $this->addSql('ALTER TABLE course_info DROP FOREIGN KEY FK_32BEC519CE8D546');
        $this->addSql('ALTER TABLE course_section DROP FOREIGN KEY FK_25B07F035548C414');
        $this->addSql('ALTER TABLE course_resource_equipment DROP FOREIGN KEY FK_E2585800517FE9FE');
        $this->addSql('ALTER TABLE course_resource_equipment DROP FOREIGN KEY FK_E25858005548C414');
        $this->addSql('ALTER TABLE course_achievement DROP FOREIGN KEY FK_E21D4F255548C414');
        $this->addSql('ALTER TABLE course_prerequisite DROP FOREIGN KEY FK_C45EDAC55548C414');
        $this->addSql('ALTER TABLE course_tutoring_resource DROP FOREIGN KEY FK_A718CCA45548C414');
        $this->addSql('ALTER TABLE course_teacher DROP FOREIGN  KEY FK_B835A3395548C414');
        $this->addSql('ALTER TABLE course_permission DROP FOREIGN  KEY FK_3FABDC295548C414');
        $this->addSql('ALTER TABLE course_permission DROP FOREIGN  KEY FK_3FABDC29A76ED395');

        // Drop new indexes
        $this->addSql('DROP INDEX IDX_32BEC51591CC992 ON course_info');
        $this->addSql('DROP INDEX IDX_32BEC512534008B ON course_info');
        $this->addSql('DROP INDEX IDX_32BEC5154C31FEE ON course_info');
        $this->addSql('DROP INDEX IDX_32BEC519CE8D546 ON course_info');
        $this->addSql('DROP INDEX IDX_32BEC5140C1FEA7 ON course_info');
        $this->addSql('DROP INDEX IDX_25B07F035548C414 ON course_section');
        $this->addSql('DROP INDEX IDX_E25858005548C414 ON course_resource_equipment');
        $this->addSql('DROP INDEX IDX_E2585800517FE9FE ON course_resource_equipment');
        $this->addSql('DROP INDEX IDX_E21D4F255548C414 ON course_achievement');
        $this->addSql('DROP INDEX IDX_C45EDAC55548C414 ON course_prerequisite');
        $this->addSql('DROP INDEX IDX_A718CCA45548C414 ON course_tutoring_resource');
        $this->addSql('DROP INDEX IDX_B835A3395548C414 ON course_teacher');
        $this->addSql('DROP INDEX IDX_3FABDC295548C414 ON course_permission');
        $this->addSql('DROP INDEX IDX_3FABDC29A76ED395 ON course_permission');

        // Drop new tables
        $this->addSql('DROP TABLE activity');
        $this->addSql('DROP TABLE course_section_activity');
        $this->addSql('DROP TABLE activity_mode');
        $this->addSql('DROP TABLE activity_type');
        $this->addSql('DROP TABLE activity_type_activity');
        $this->addSql('DROP TABLE activity_type_activity_mode');

        // Recreate old tables
        $this->addSql('CREATE TABLE course_domain (id CHAR(36) NOT NULL, course_info_id CHAR(36) NOT NULL, domain VARCHAR(255) DEFAULT NULL, INDEX fk_course_domain_course_info1_idx (course_info_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course_domain ADD CONSTRAINT FK_991DF465548C414 FOREIGN KEY (course_info_id) REFERENCES course_info (id)');

        $this->addSql('ALTER TABLE bak_activity RENAME TO activity');
        $this->addSql('ALTER TABLE bak_course_section_activity RENAME TO course_section_activity');
        $this->addSql('ALTER TABLE bak_course_evaluation_ct RENAME TO course_evaluation_ct');

        // Rename fields
        $this->addSql('ALTER TABLE course_achievement CHANGE position ord INT NOT NULL');
        $this->addSql('ALTER TABLE course_prerequisite CHANGE position ord INT NOT NULL');
        $this->addSql('ALTER TABLE course_resource_equipment CHANGE ord position INT NOT NULL');
        $this->addSql('ALTER TABLE course_section CHANGE position ord INT NOT NULL');
        $this->addSql('ALTER TABLE course CHANGE code etb_id CHAR(36) NOT NULL');
        $this->addSql('ALTER TABLE structure CHANGE code etbId CHAR(36) NOT NULL');

        // Recreate old indexes
        $this->addSql('CREATE INDEX fk_course_info_course1_idx ON course_info (course_id)');
        $this->addSql('CREATE INDEX fk_course_info_structure1_idx ON course_info (structure_id)');
        $this->addSql('CREATE INDEX fk_course_info_user1_idx ON course_info (last_updater)');
        $this->addSql('CREATE INDEX fk_course_info_user2_idx ON course_info (publisher)');
        $this->addSql('CREATE INDEX fk_course_info_year1_idx ON course_info (year_id)');
        $this->addSql('CREATE INDEX fk_course_section_course_info1_idx ON course_section (course_info_id)');
        $this->addSql('CREATE INDEX fk_course_resource_equipment_course_info1_idx ON course_resource_equipment (course_info_id)');
        $this->addSql('CREATE INDEX fk_course_resource_equipment_equipment1_idx ON course_resource_equipment (equipment_id)');
        $this->addSql('CREATE INDEX fk_course_achievement_course_info1_idx ON course_achievement (course_info_id)');
        $this->addSql('CREATE INDEX fk_course_prerequisite_course_info1_idx ON course_prerequisite (course_info_id)');
        $this->addSql('CREATE INDEX fk_course_tutoring_resources_course_info1_idx ON course_tutoring_resource (course_info_id)');
        $this->addSql('CREATE INDEX fk_course_teacher_course_info1_idx ON course_teacher (course_info_id)');
        $this->addSql('CREATE INDEX fk_course_permission_course_info1_idx ON course_permission (course_info_id)');
        $this->addSql('CREATE INDEX fk_course_permission_user1_idx ON course_permission (user_id)');

        // Recreate old foreign key
        $this->addSql('ALTER TABLE course_evaluation_ct ADD CONSTRAINT FK_61B9EA7181C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
        $this->addSql('ALTER TABLE course_section_activity ADD CONSTRAINT FK_B95D28E681C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
        $this->addSql('ALTER TABLE course_info ADD CONSTRAINT FK_32BEC51591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE course_info ADD CONSTRAINT FK_32BEC512534008B FOREIGN KEY (structure_id) REFERENCES structure (id)');
        $this->addSql('ALTER TABLE course_info ADD CONSTRAINT FK_32BEC5154C31FEE FOREIGN KEY (last_updater) REFERENCES user (id)');
        $this->addSql('ALTER TABLE course_info ADD CONSTRAINT FK_32BEC519CE8D546 FOREIGN KEY (publisher) REFERENCES user (id)');
        $this->addSql('ALTER TABLE course_info ADD CONSTRAINT FK_32BEC5140C1FEA7 FOREIGN KEY (year_id) REFERENCES year (id)');
        $this->addSql('ALTER TABLE course_section ADD CONSTRAINT FK_25B07F035548C414 FOREIGN KEY (course_info_id) REFERENCES course_info (id)');
        $this->addSql('ALTER TABLE course_resource_equipment ADD CONSTRAINT FK_E2585800517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id)');
        $this->addSql('ALTER TABLE course_resource_equipment ADD CONSTRAINT FK_E25858005548C414 FOREIGN KEY (course_info_id) REFERENCES course_info (id)');
        $this->addSql('ALTER TABLE course_achievement ADD CONSTRAINT FK_E21D4F255548C414 FOREIGN KEY (course_info_id) REFERENCES course_info (id)');
        $this->addSql('ALTER TABLE course_prerequisite ADD CONSTRAINT FK_C45EDAC55548C414 FOREIGN KEY (course_info_id) REFERENCES course_info (id)');
        $this->addSql('ALTER TABLE course_tutoring_resource ADD CONSTRAINT FK_A718CCA45548C414 FOREIGN KEY (course_info_id) REFERENCES course_info (id)');
        $this->addSql('ALTER TABLE course_teacher ADD CONSTRAINT FK_B835A3395548C414 FOREIGN KEY (course_info_id) REFERENCES course_info (id)');
        $this->addSql('ALTER TABLE course_permission ADD CONSTRAINT FK_3FABDC295548C414 FOREIGN KEY (course_info_id) REFERENCES course_info (id)');
        $this->addSql('ALTER TABLE course_permission ADD CONSTRAINT FK_3FABDC29A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');

    }
}
