<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200323091359 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE level (id CHAR(36) NOT NULL, label VARCHAR(100) NOT NULL, obsolete TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('UPDATE course_info_field SET field = \'domains\' WHERE field = \'domain\'');
        $this->addSql('UPDATE course_info_field SET field = \'periods\' WHERE field = \'period\'');
        $this->addSql('DELETE FROM course_info_field WHERE field = \'courseEvaluationCts\'');
        $this->addSql('CREATE TABLE dmishh_settings (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value LONGTEXT DEFAULT NULL, owner_id VARCHAR(255) DEFAULT NULL, INDEX name_owner_id_idx (name, owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_courseprerequisite (course_id CHAR(36) NOT NULL, courseprerequisite_id CHAR(36) NOT NULL, INDEX IDX_F6EEFE0E591CC992 (course_id), INDEX IDX_F6EEFE0E4DF42D0 (courseprerequisite_id), PRIMARY KEY(course_id, courseprerequisite_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course_courseprerequisite ADD CONSTRAINT FK_F6EEFE0E591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_courseprerequisite ADD CONSTRAINT FK_F6EEFE0E4DF42D0 FOREIGN KEY (courseprerequisite_id) REFERENCES course_prerequisite (id) ON DELETE CASCADE');
        $this->addSql('CREATE TABLE teaching (id CHAR(36) NOT NULL, course_info_id CHAR(36) NOT NULL, type VARCHAR(65) NOT NULL, hourlyVolume DOUBLE PRECISION NOT NULL, mode VARCHAR(15) NOT NULL, INDEX IDX_18B06FB25548C414 (course_info_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE teaching ADD CONSTRAINT FK_18B06FB25548C414 FOREIGN KEY (course_info_id) REFERENCES course_info (id)');
        $this->addSql('CREATE TABLE courseinfo_level (courseinfo_id CHAR(36) NOT NULL, level_id CHAR(36) NOT NULL, INDEX IDX_5F8EE857A80E736 (courseinfo_id), INDEX IDX_5F8EE8575FB14BA7 (level_id), PRIMARY KEY(courseinfo_id, level_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE courseinfo_level ADD CONSTRAINT FK_5F8EE857A80E736 FOREIGN KEY (courseinfo_id) REFERENCES course_info (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE courseinfo_level ADD CONSTRAINT FK_5F8EE8575FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_info DROP level');
        $this->addSql('ALTER TABLE level ADD code VARCHAR(50) DEFAULT NULL, ADD source VARCHAR(50) DEFAULT NULL, ADD synchronized TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE period ADD code VARCHAR(50) DEFAULT NULL, ADD source VARCHAR(50) DEFAULT NULL, ADD synchronized TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE language ADD code VARCHAR(50) DEFAULT NULL, ADD source VARCHAR(50) DEFAULT NULL, ADD synchronized TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE course_info DROP semester');
        $this->addSql('ALTER TABLE course_section ADD url TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE domain ADD code VARCHAR(50) DEFAULT NULL, ADD source VARCHAR(50) DEFAULT NULL, ADD synchronized TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE domain DROP code, DROP source, DROP synchronized');
        $this->addSql('UPDATE course_info_field SET field = \'domain\' WHERE field = \'domains\'');
        $this->addSql('UPDATE course_info_field SET field = \'period\' WHERE field = \'periods\'');
        $this->addSql('INSERT INTO course_info_field (field, label) VALUES (\'courseEvaluationCts\', \'Contenu & Activités / Evaluations CT\')');
        $this->addSql('DROP TABLE level');
        $this->addSql('DROP TABLE dmishh_settings');
        $this->addSql('DROP TABLE course_courseprerequisite');
        $this->addSql('ALTER TABLE course_info ADD semester INT DEFAULT NULL');
        $this->addSql('ALTER TABLE course_section DROP url');
        $this->addSql('DROP TABLE teaching');
        $this->addSql('DROP TABLE courseinfo_level');
        $this->addSql('ALTER TABLE course_info ADD level CHAR(15) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE level DROP code, DROP source, DROP synchronized');
        $this->addSql('ALTER TABLE period DROP code, DROP source, DROP synchronized');
        $this->addSql('ALTER TABLE language DROP code, DROP source, DROP synchronized');
    }
}
