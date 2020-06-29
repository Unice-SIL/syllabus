<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200218093301 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE campus (id CHAR(36) NOT NULL, `label` VARCHAR(100) NOT NULL, obsolete TINYINT(1) NOT NULL, code VARCHAR(50) DEFAULT NULL, source VARCHAR(50) DEFAULT NULL, synchronized TINYINT(1) NOT NULL, UNIQUE INDEX code_source_on_campus_UNIQUE (code, source), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_info_campus (courseinfo_id CHAR(36) NOT NULL, campus_id CHAR(36) NOT NULL, INDEX IDX_24BA0793A80E736 (courseinfo_id), INDEX IDX_24BA0793AF5D55E1 (campus_id), PRIMARY KEY(courseinfo_id, campus_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_info_language (courseinfo_id CHAR(36) NOT NULL, language_id CHAR(36) NOT NULL, INDEX IDX_634E06A80E736 (courseinfo_id), INDEX IDX_634E0682F1BAF4 (language_id), PRIMARY KEY(courseinfo_id, language_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_info_domain (courseinfo_id CHAR(36) NOT NULL, domain_id CHAR(36) NOT NULL, INDEX IDX_1E1A7189A80E736 (courseinfo_id), INDEX IDX_1E1A7189115F0EE5 (domain_id), PRIMARY KEY(courseinfo_id, domain_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_info_period (courseinfo_id CHAR(36) NOT NULL, period_id CHAR(36) NOT NULL, INDEX IDX_7C0B714CA80E736 (courseinfo_id), INDEX IDX_7C0B714CEC8B7ADE (period_id), PRIMARY KEY(courseinfo_id, period_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE domain (id CHAR(36) NOT NULL, `label` VARCHAR(255) NOT NULL, obsolete TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE domain_structure (domain_id CHAR(36) NOT NULL, structure_id CHAR(36) NOT NULL, INDEX IDX_8971E5A4115F0EE5 (domain_id), INDEX IDX_8971E5A42534008B (structure_id), PRIMARY KEY(domain_id, structure_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groups (id VARCHAR(255) NOT NULL, `label` VARCHAR(50) NOT NULL, obsolete TINYINT(1) NOT NULL, roles LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_F06D3970EA750E8 (`label`), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language (id CHAR(36) NOT NULL, `label` VARCHAR(100) NOT NULL, obsolete TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE period (id CHAR(36) NOT NULL, `label` VARCHAR(100) NOT NULL, obsolete TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE period_structure (period_id CHAR(36) NOT NULL, structure_id CHAR(36) NOT NULL, INDEX IDX_BBDF4C38EC8B7ADE (period_id), INDEX IDX_BBDF4C382534008B (structure_id), PRIMARY KEY(period_id, structure_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_groups (user_id CHAR(36) NOT NULL, groups_id VARCHAR(255) NOT NULL, INDEX IDX_953F224DA76ED395 (user_id), INDEX IDX_953F224DF373DCF (groups_id), PRIMARY KEY(user_id, groups_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course_info_campus ADD CONSTRAINT FK_24BA0793A80E736 FOREIGN KEY (courseinfo_id) REFERENCES course_info (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_info_campus ADD CONSTRAINT FK_24BA0793AF5D55E1 FOREIGN KEY (campus_id) REFERENCES campus (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_info_language ADD CONSTRAINT FK_634E06A80E736 FOREIGN KEY (courseinfo_id) REFERENCES course_info (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_info_language ADD CONSTRAINT FK_634E0682F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_info_domain ADD CONSTRAINT FK_1E1A7189A80E736 FOREIGN KEY (courseinfo_id) REFERENCES course_info (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_info_domain ADD CONSTRAINT FK_1E1A7189115F0EE5 FOREIGN KEY (domain_id) REFERENCES domain (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_info_period ADD CONSTRAINT FK_7C0B714CA80E736 FOREIGN KEY (courseinfo_id) REFERENCES course_info (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_info_period ADD CONSTRAINT FK_7C0B714CEC8B7ADE FOREIGN KEY (period_id) REFERENCES period (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE domain_structure ADD CONSTRAINT FK_8971E5A4115F0EE5 FOREIGN KEY (domain_id) REFERENCES domain (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE domain_structure ADD CONSTRAINT FK_8971E5A42534008B FOREIGN KEY (structure_id) REFERENCES structure (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE period_structure ADD CONSTRAINT FK_BBDF4C38EC8B7ADE FOREIGN KEY (period_id) REFERENCES period (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE period_structure ADD CONSTRAINT FK_BBDF4C382534008B FOREIGN KEY (structure_id) REFERENCES structure (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_groups ADD CONSTRAINT FK_953F224DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_groups ADD CONSTRAINT FK_953F224DF373DCF FOREIGN KEY (groups_id) REFERENCES groups (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activity CHANGE description description VARCHAR(400) DEFAULT NULL');
        $this->addSql('ALTER TABLE bak_course_evaluation_ct DROP FOREIGN KEY FK_61B9EA715548C414');
        $this->addSql('DROP INDEX fk_course_evaluation_ct_activity1_idx ON bak_course_evaluation_ct');
        $this->addSql('CREATE INDEX IDX_613A661781C06096 ON bak_course_evaluation_ct (activity_id)');
        $this->addSql('DROP INDEX fk_course_evaluation_ct_course_info1_idx ON bak_course_evaluation_ct');
        $this->addSql('CREATE INDEX IDX_613A66175548C414 ON bak_course_evaluation_ct (course_info_id)');
        $this->addSql('ALTER TABLE bak_course_evaluation_ct ADD CONSTRAINT FK_613A661781C06096 FOREIGN KEY (activity_id) REFERENCES bak_activity (id)');
        $this->addSql('ALTER TABLE bak_course_evaluation_ct ADD CONSTRAINT FK_61B9EA715548C414 FOREIGN KEY (course_info_id) REFERENCES course_info (id)');
        $this->addSql('DROP INDEX fk_course_section_activity_activity1_idx ON bak_course_section_activity');
        $this->addSql('CREATE INDEX IDX_16809AA981C06096 ON bak_course_section_activity (activity_id)');
        $this->addSql('DROP INDEX fk_course_section_activity_course_section1_idx ON bak_course_section_activity');
        $this->addSql('CREATE INDEX IDX_16809AA97C1ADF9 ON bak_course_section_activity (course_section_id)');
        $this->addSql('ALTER TABLE bak_course_section_activity ADD CONSTRAINT FK_16809AA981C06096 FOREIGN KEY (activity_id) REFERENCES bak_activity (id)');
        $this->addSql('ALTER TABLE bak_course_section_activity ADD CONSTRAINT FK_B95D28E67C1ADF8 FOREIGN KEY (course_section_id) REFERENCES course_section (id)');
        $this->addSql('DROP INDEX etb_id_UNIQUE ON course');
        $this->addSql('ALTER TABLE course ADD title VARCHAR(150) NOT NULL, ADD source VARCHAR(50) DEFAULT NULL, ADD synchronized TINYINT(1) NOT NULL, CHANGE code code VARCHAR(50) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX code_source_on_course_UNIQUE ON course (code, source)');
        $this->addSql('ALTER TABLE course_info DROP COLUMN domain, DROP COLUMN period, DROP tem_presentation_tab_valid, DROP COLUMN tem_activities_tab_valid, DROP COLUMN tem_objectives_tab_valid, DROP COLUMN tem_mcc_tab_valid, DROP COLUMN tem_equipments_tab_valid, DROP COLUMN tem_infos_tab_valid, DROP COLUMN tem_closing_remarks_tab_valid');
        $this->addSql('ALTER TABLE course_info CHANGE COLUMN languages bak_languages VARCHAR(200)');
        $this->addSql('ALTER TABLE course_section_activity ADD evaluable TINYINT(1) NOT NULL, ADD evaluation_ct TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE course_tutoring_resource CHANGE ord position INT NOT NULL');
        $this->addSql('ALTER TABLE equipment CHANGE ord position INT NOT NULL');
        $this->addSql('ALTER TABLE structure ADD source VARCHAR(50) DEFAULT NULL, ADD synchronized TINYINT(1) NOT NULL, DROP COLUMN campus, CHANGE code code VARCHAR(50) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX code_source_on_structure_UNIQUE ON structure (code, source)');
        $this->addSql('ALTER TABLE user ADD resetPasswordToken VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE course_info_campus DROP FOREIGN KEY FK_24BA0793AF5D55E1');
        $this->addSql('ALTER TABLE course_info_domain DROP FOREIGN KEY FK_1E1A7189115F0EE5');
        $this->addSql('ALTER TABLE domain_structure DROP FOREIGN KEY FK_8971E5A4115F0EE5');
        $this->addSql('ALTER TABLE user_groups DROP FOREIGN KEY FK_953F224DF373DCF');
        $this->addSql('ALTER TABLE course_info_language DROP FOREIGN KEY FK_634E0682F1BAF4');
        $this->addSql('ALTER TABLE course_info_period DROP FOREIGN KEY FK_7C0B714CEC8B7ADE');
        $this->addSql('ALTER TABLE period_structure DROP FOREIGN KEY FK_BBDF4C38EC8B7ADE');
        $this->addSql('DROP TABLE campus');
        $this->addSql('DROP TABLE course_info_campus');
        $this->addSql('DROP TABLE course_info_language');
        $this->addSql('DROP TABLE course_info_domain');
        $this->addSql('DROP TABLE course_info_period');
        $this->addSql('DROP TABLE domain');
        $this->addSql('DROP TABLE domain_structure');
        $this->addSql('DROP TABLE groups');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE period');
        $this->addSql('DROP TABLE period_structure');
        $this->addSql('DROP TABLE user_groups');
        $this->addSql('ALTER TABLE activity CHANGE description description VARCHAR(200) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE bak_course_evaluation_ct DROP FOREIGN KEY FK_613A661781C06096');
        $this->addSql('ALTER TABLE bak_course_evaluation_ct DROP FOREIGN KEY FK_613A661781C06096');
        $this->addSql('ALTER TABLE bak_course_evaluation_ct DROP FOREIGN KEY FK_613A66175548C414');
        $this->addSql('DROP INDEX idx_613a66175548c414 ON bak_course_evaluation_ct');
        $this->addSql('CREATE INDEX fk_course_evaluation_ct_course_info1_idx ON bak_course_evaluation_ct (course_info_id)');
        $this->addSql('DROP INDEX idx_613a661781c06096 ON bak_course_evaluation_ct');
        $this->addSql('CREATE INDEX fk_course_evaluation_ct_activity1_idx ON bak_course_evaluation_ct (activity_id)');
        $this->addSql('ALTER TABLE bak_course_evaluation_ct ADD CONSTRAINT FK_613A661781C06096 FOREIGN KEY (activity_id) REFERENCES bak_activity (id)');
        $this->addSql('ALTER TABLE bak_course_evaluation_ct ADD CONSTRAINT FK_613A66175548C414 FOREIGN KEY (course_info_id) REFERENCES course_info (id)');
        $this->addSql('ALTER TABLE bak_course_section_activity DROP FOREIGN KEY FK_16809AA981C06096');
        $this->addSql('ALTER TABLE bak_course_section_activity DROP FOREIGN KEY FK_16809AA97C1ADF9');
        $this->addSql('DROP INDEX idx_16809aa97c1adf9 ON bak_course_section_activity');
        $this->addSql('CREATE INDEX fk_course_section_activity_course_section1_idx ON bak_course_section_activity (course_section_id)');
        $this->addSql('DROP INDEX idx_16809aa981c06096 ON bak_course_section_activity');
        $this->addSql('CREATE INDEX fk_course_section_activity_activity1_idx ON bak_course_section_activity (activity_id)');
        $this->addSql('ALTER TABLE bak_course_section_activity ADD CONSTRAINT FK_16809AA981C06096 FOREIGN KEY (activity_id) REFERENCES bak_activity (id)');
        $this->addSql('ALTER TABLE bak_course_section_activity ADD CONSTRAINT FK_16809AA97C1ADF9 FOREIGN KEY (course_section_id) REFERENCES course_section (id)');
        $this->addSql('DROP INDEX code_source_on_course_UNIQUE ON course');
        $this->addSql('ALTER TABLE course DROP title, DROP source, DROP synchronized, CHANGE code code CHAR(36) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('CREATE UNIQUE INDEX etb_id_UNIQUE ON course (code)');
        $this->addSql('ALTER TABLE course_info CHANGE COLUMN bak_languages languages VARCHAR(200)');
        $this->addSql('ALTER TABLE course_info ADD domain CHAR(100) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, ADD period VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, ADD tem_presentation_tab_valid TINYINT(1) NOT NULL, ADD tem_activities_tab_valid TINYINT(1) NOT NULL, ADD tem_objectives_tab_valid TINYINT(1) NOT NULL, ADD tem_mcc_tab_valid TINYINT(1) NOT NULL, ADD tem_equipments_tab_valid TINYINT(1) NOT NULL, ADD tem_infos_tab_valid TINYINT(1) NOT NULL, ADD tem_closing_remarks_tab_valid TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE course_section_activity DROP FOREIGN KEY FK_B95D28E67C1ADF9');
        $this->addSql('ALTER TABLE course_section_activity DROP evaluable, DROP evaluation_ct');
        $this->addSql('ALTER TABLE course_tutoring_resource CHANGE position ord INT NOT NULL');
        $this->addSql('ALTER TABLE equipment CHANGE position ord INT NOT NULL');
        $this->addSql('DROP INDEX code_source_on_structure_UNIQUE ON structure');
        $this->addSql('ALTER TABLE structure ADD campus VARCHAR(100) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, DROP source, DROP synchronized, CHANGE code code CHAR(36) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE user DROP resetPasswordToken');
    }
}
