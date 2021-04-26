<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210423084653 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE activity_mode_translations CHANGE object_class object_class VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE activity_translations CHANGE object_class object_class VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE activity_type_translations CHANGE object_class object_class VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE ask_advice_translations CHANGE object_class object_class VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE campus_translations CHANGE object_class object_class VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE course_achievement_translations CHANGE object_class object_class VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE course_critical_achievement_translations CHANGE object_class object_class VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE course_info_field_translations CHANGE object_class object_class VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE course_info_translations CHANGE object_class object_class VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE course_permission_translations CHANGE object_class object_class VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE course_prerequisite ADD is_course_associated TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE course_prerequisite_translations CHANGE object_class object_class VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE course_resource_equipment_translations CHANGE object_class object_class VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE course_section_activity_translations CHANGE object_class object_class VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE course_section_translations CHANGE object_class object_class VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE course_teacher_translations CHANGE object_class object_class VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE course_translations CHANGE object_class object_class VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE course_tutoring_resource_translations CHANGE object_class object_class VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE critcal_achievement_translations CHANGE object_class object_class VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE domain_translations CHANGE object_class object_class VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE equipment_translations CHANGE object_class object_class VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE ext_translations CHANGE object_class object_class VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE groups_translations CHANGE object_class object_class VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE job_translations CHANGE object_class object_class VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE language_translations CHANGE object_class object_class VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE learning_achievement_translations CHANGE object_class object_class VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE notification_translations CHANGE object_class object_class VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE period_translations CHANGE object_class object_class VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE structure_translations CHANGE object_class object_class VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE user_translations CHANGE object_class object_class VARCHAR(191) NOT NULL');
        $this->addSql('ALTER TABLE year CHANGE label label CHAR(45) NOT NULL');
        $this->addSql('ALTER TABLE year_translations CHANGE object_class object_class VARCHAR(191) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE activity_mode_translations CHANGE object_class object_class VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE activity_translations CHANGE object_class object_class VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE activity_type_translations CHANGE object_class object_class VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE ask_advice_translations CHANGE object_class object_class VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE campus_translations CHANGE object_class object_class VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE course_achievement_translations CHANGE object_class object_class VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE course_critical_achievement_translations CHANGE object_class object_class VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE course_info_field_translations CHANGE object_class object_class VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE course_info_translations CHANGE object_class object_class VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE course_permission_translations CHANGE object_class object_class VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE course_prerequisite DROP is_course_associated');
        $this->addSql('ALTER TABLE course_prerequisite_translations CHANGE object_class object_class VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE course_resource_equipment_translations CHANGE object_class object_class VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE course_section_activity_translations CHANGE object_class object_class VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE course_section_translations CHANGE object_class object_class VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE course_teacher_translations CHANGE object_class object_class VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE course_translations CHANGE object_class object_class VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE course_tutoring_resource_translations CHANGE object_class object_class VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE critcal_achievement_translations CHANGE object_class object_class VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE domain_translations CHANGE object_class object_class VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE equipment_translations CHANGE object_class object_class VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE ext_translations CHANGE object_class object_class VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE groups_translations CHANGE object_class object_class VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE job_translations CHANGE object_class object_class VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE language_translations CHANGE object_class object_class VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE learning_achievement_translations CHANGE object_class object_class VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE notification_translations CHANGE object_class object_class VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE period_translations CHANGE object_class object_class VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE structure_translations CHANGE object_class object_class VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE user_translations CHANGE object_class object_class VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE year CHANGE label label CHAR(45) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE year_translations CHANGE object_class object_class VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
    }
}
