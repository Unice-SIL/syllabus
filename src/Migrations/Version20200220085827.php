<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200220085827 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE course_criticalachievement (course_id CHAR(36) NOT NULL, criticalachievement_id CHAR(36) NOT NULL, INDEX IDX_14CBE7DC591CC992 (course_id), INDEX IDX_14CBE7DC9495AB3E (criticalachievement_id), PRIMARY KEY(course_id, criticalachievement_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_critical_achievement (id CHAR(36) NOT NULL, critical_achievement_course_critical_achievement CHAR(36) DEFAULT NULL, course_info_course_critical_achievement CHAR(36) DEFAULT NULL, rule INT NOT NULL, score INT NOT NULL, INDEX IDX_8D9329E238D2F79A (critical_achievement_course_critical_achievement), INDEX IDX_8D9329E221733CA3 (course_info_course_critical_achievement), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE critical_achievement (id CHAR(36) NOT NULL, label VARCHAR(100) NOT NULL, obsolete TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE learning_achievement (id CHAR(36) NOT NULL, course_critical_achievement_learning_achievement CHAR(36) DEFAULT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_B4A2459729B8CE33 (course_critical_achievement_learning_achievement), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course_criticalachievement ADD CONSTRAINT FK_14CBE7DC591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_criticalachievement ADD CONSTRAINT FK_14CBE7DC9495AB3E FOREIGN KEY (criticalachievement_id) REFERENCES critical_achievement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_critical_achievement ADD CONSTRAINT FK_8D9329E238D2F79A FOREIGN KEY (critical_achievement_course_critical_achievement) REFERENCES critical_achievement (id)');
        $this->addSql('ALTER TABLE course_critical_achievement ADD CONSTRAINT FK_8D9329E221733CA3 FOREIGN KEY (course_info_course_critical_achievement) REFERENCES course_info (id)');
        $this->addSql('ALTER TABLE learning_achievement ADD CONSTRAINT FK_B4A2459729B8CE33 FOREIGN KEY (course_critical_achievement_learning_achievement) REFERENCES learning_achievement (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE course_criticalachievement DROP FOREIGN KEY FK_14CBE7DC9495AB3E');
        $this->addSql('ALTER TABLE course_critical_achievement DROP FOREIGN KEY FK_8D9329E238D2F79A');
        $this->addSql('ALTER TABLE learning_achievement DROP FOREIGN KEY FK_B4A2459729B8CE33');
        $this->addSql('DROP TABLE course_criticalachievement');
        $this->addSql('DROP TABLE course_critical_achievement');
        $this->addSql('DROP TABLE critical_achievement');
        $this->addSql('DROP TABLE learning_achievement');
    }
}
