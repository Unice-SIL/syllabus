<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200318170144 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE course_courseprerequisite (course_id CHAR(36) NOT NULL, courseprerequisite_id CHAR(36) NOT NULL, INDEX IDX_F6EEFE0E591CC992 (course_id), INDEX IDX_F6EEFE0E4DF42D0 (courseprerequisite_id), PRIMARY KEY(course_id, courseprerequisite_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course_courseprerequisite ADD CONSTRAINT FK_F6EEFE0E591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_courseprerequisite ADD CONSTRAINT FK_F6EEFE0E4DF42D0 FOREIGN KEY (courseprerequisite_id) REFERENCES course_prerequisite (id) ON DELETE CASCADE');
        //$this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9621C039');
        //$this->addSql('DROP INDEX IDX_169E6FB9621C039 ON course');
        //$this->addSql('ALTER TABLE course DROP course_prerequisite_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE course_courseprerequisite');
        //$this->addSql('ALTER TABLE course ADD course_prerequisite_id CHAR(36) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`');
        //$this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9621C039 FOREIGN KEY (course_prerequisite_id) REFERENCES course_prerequisite (id)');
        //$this->addSql('CREATE INDEX IDX_169E6FB9621C039 ON course (course_prerequisite_id)');
    }
}
