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

        $this->addSql('CREATE TABLE courseinfo_level (courseinfo_id CHAR(36) NOT NULL, level_id CHAR(36) NOT NULL, INDEX IDX_5F8EE857A80E736 (courseinfo_id), INDEX IDX_5F8EE8575FB14BA7 (level_id), PRIMARY KEY(courseinfo_id, level_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE courseinfo_level ADD CONSTRAINT FK_5F8EE857A80E736 FOREIGN KEY (courseinfo_id) REFERENCES course_info (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE courseinfo_level ADD CONSTRAINT FK_5F8EE8575FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_info DROP level');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE courseinfo_level');
        $this->addSql('ALTER TABLE course_info ADD level CHAR(15) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`');
    }
}
