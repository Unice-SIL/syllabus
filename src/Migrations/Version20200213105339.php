<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200213105339 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE campus ADD code VARCHAR(50) NOT NULL, ADD source VARCHAR(50) DEFAULT \'import effectué avant la mise en place de ce champ\'');
        $this->addSql('ALTER TABLE course CHANGE source source VARCHAR(50) DEFAULT \'import effectué avant la mise en place de ce champ\'');
        $this->addSql('CREATE UNIQUE INDEX code_UNIQUE ON course (code)');
        $this->addSql('ALTER TABLE course_achievement CHANGE ord position INT NOT NULL');
        $this->addSql('ALTER TABLE course_prerequisite CHANGE ord position INT NOT NULL');
        $this->addSql('ALTER TABLE course_resource_equipment CHANGE ord position INT NOT NULL');
        //$this->addSql('ALTER TABLE course_section_activity CHANGE activity_type_id activity_type_id CHAR(36) NOT NULL, CHANGE activity_mode_id activity_mode_id CHAR(36) NOT NULL');
        //$this->addSql('ALTER TABLE course_section_activity ADD CONSTRAINT FK_B95D28E67C1ADF9 FOREIGN KEY (course_section_id) REFERENCES course_section (id)');
        $this->addSql('ALTER TABLE course_tutoring_resource CHANGE ord position INT NOT NULL');
        $this->addSql('ALTER TABLE equipment CHANGE ord position INT NOT NULL');
        $this->addSql('ALTER TABLE structure DROP campus, CHANGE source source VARCHAR(50) DEFAULT \'import effectué avant la mise en place de ce champ\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE campus DROP code, DROP source');
        $this->addSql('DROP INDEX code_UNIQUE ON course');
        $this->addSql('ALTER TABLE course CHANGE source source VARCHAR(50) CHARACTER SET utf8 DEFAULT \'import effectué avant la mise en place de ce champ\' NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE course_achievement CHANGE position ord INT NOT NULL');
        $this->addSql('ALTER TABLE course_prerequisite CHANGE position ord INT NOT NULL');
        $this->addSql('ALTER TABLE course_resource_equipment CHANGE position ord INT NOT NULL');
        //$this->addSql('ALTER TABLE course_section_activity DROP FOREIGN KEY FK_B95D28E67C1ADF9');
        //$this->addSql('ALTER TABLE course_section_activity CHANGE activity_type_id activity_type_id CHAR(36) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, CHANGE activity_mode_id activity_mode_id CHAR(36) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE course_tutoring_resource CHANGE position ord INT NOT NULL');
        $this->addSql('ALTER TABLE equipment CHANGE position ord INT NOT NULL');
        $this->addSql('ALTER TABLE structure ADD campus VARCHAR(100) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, CHANGE source source VARCHAR(50) CHARACTER SET utf8 DEFAULT \'import effectué avant la mise en place de ce champ\' NOT NULL COLLATE `utf8_unicode_ci`');
    }
}
