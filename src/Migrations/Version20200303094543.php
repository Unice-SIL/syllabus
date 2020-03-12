<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200303094543 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ask_advice (id CHAR(36) NOT NULL, description LONGTEXT NOT NULL, user LONGTEXT NOT NULL COMMENT \'(DC2Type:object)\', course_info LONGTEXT NOT NULL COMMENT \'(DC2Type:object)\', process TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_criticalachievement (course_id CHAR(36) NOT NULL, criticalachievement_id CHAR(36) NOT NULL, INDEX IDX_14CBE7DC591CC992 (course_id), INDEX IDX_14CBE7DC9495AB3E (criticalachievement_id), PRIMARY KEY(course_id, criticalachievement_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_critical_achievement (id CHAR(36) NOT NULL, critical_achievement_course_critical_achievement CHAR(36) DEFAULT NULL, course_info_course_critical_achievement CHAR(36) DEFAULT NULL, rule TINYTEXT NOT NULL, score INT NOT NULL, code VARCHAR(50) DEFAULT NULL, source VARCHAR(50) DEFAULT NULL, synchronized TINYINT(1) NOT NULL, INDEX IDX_8D9329E238D2F79A (critical_achievement_course_critical_achievement), INDEX IDX_8D9329E221733CA3 (course_info_course_critical_achievement), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE critical_achievement (id CHAR(36) NOT NULL, label VARCHAR(100) NOT NULL, obsolete TINYINT(1) NOT NULL, code VARCHAR(50) DEFAULT NULL, source VARCHAR(50) DEFAULT NULL, synchronized TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job (id CHAR(36) NOT NULL, label VARCHAR(60) NOT NULL, command VARCHAR(255) NOT NULL, frequency_job_format VARCHAR(255) NOT NULL, last_use_start DATETIME DEFAULT NULL, last_use_end DATETIME DEFAULT NULL, last_status INT DEFAULT NULL, obsolete TINYINT(1) NOT NULL, immediately TINYINT(1) NOT NULL, report LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE learning_achievement (id CHAR(36) NOT NULL, course_critical_achievement_learning_achievement CHAR(36) DEFAULT NULL, description VARCHAR(255) NOT NULL, score INT NOT NULL, code VARCHAR(50) DEFAULT NULL, source VARCHAR(50) DEFAULT NULL, synchronized TINYINT(1) NOT NULL, INDEX IDX_B4A2459729B8CE33 (course_critical_achievement_learning_achievement), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course_criticalachievement ADD CONSTRAINT FK_14CBE7DC591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_criticalachievement ADD CONSTRAINT FK_14CBE7DC9495AB3E FOREIGN KEY (criticalachievement_id) REFERENCES critical_achievement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_critical_achievement ADD CONSTRAINT FK_8D9329E238D2F79A FOREIGN KEY (critical_achievement_course_critical_achievement) REFERENCES critical_achievement (id)');
        $this->addSql('ALTER TABLE course_critical_achievement ADD CONSTRAINT FK_8D9329E221733CA3 FOREIGN KEY (course_info_course_critical_achievement) REFERENCES course_info (id)');
        $this->addSql('ALTER TABLE learning_achievement ADD CONSTRAINT FK_B4A2459729B8CE33 FOREIGN KEY (course_critical_achievement_learning_achievement) REFERENCES course_critical_achievement (id)');
        $this->addSql('ALTER TABLE course_info_field ADD import TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE course_permission ADD code VARCHAR(50) DEFAULT NULL, ADD source VARCHAR(50) DEFAULT NULL, ADD synchronized TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE learning_achievement DROP FOREIGN KEY FK_B4A2459729B8CE33');
        $this->addSql('ALTER TABLE course_criticalachievement DROP FOREIGN KEY FK_14CBE7DC9495AB3E');
        $this->addSql('ALTER TABLE course_critical_achievement DROP FOREIGN KEY FK_8D9329E238D2F79A');
        $this->addSql('DROP TABLE ask_advice');
        $this->addSql('DROP TABLE course_criticalachievement');
        $this->addSql('DROP TABLE course_critical_achievement');
        $this->addSql('DROP TABLE critical_achievement');
        $this->addSql('DROP TABLE job');
        $this->addSql('DROP TABLE learning_achievement');
        $this->addSql('ALTER TABLE course_info_field DROP import');
        $this->addSql('ALTER TABLE course_permission DROP code, DROP source, DROP synchronized');
    }
}
