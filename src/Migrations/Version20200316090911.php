<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200316090911 extends AbstractMigration
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
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('UPDATE course_info_field SET field = \'domain\' WHERE field = \'domains\'');
        $this->addSql('UPDATE course_info_field SET field = \'period\' WHERE field = \'periods\'');
        $this->addSql('INSERT INTO course_info_field (field, label) VALUES (\'courseEvaluationCts\', \'Contenu & Activités / Evaluations CT\')');

        $this->addSql('DROP TABLE level');
    }
}
