<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200218100620 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE course_info_field ADD import TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('UPDATE course_info_field SET field = \'domains\' where field = \'domain\' ' );
        $this->addSql('UPDATE course_info_field SET field = \'periods\' where field = \'period\' ' );
        $this->addSql('INSERT INTO course_info_field (field, label) VALUES (\'campuses\', \'Campus\')' );
        $this->addSql('DELETE FROM course_info_field WHERE field = \'courseEvaluationCts\' ' );
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE course_info_field DROP import');
        $this->addSql('UPDATE course_info_field SET field = \'domain\' where field = \'domains\' ' );
        $this->addSql('UPDATE course_info_field SET field = \'period\' where field = \'periods\' ' );
        $this->addSql('DELETE FROM course_info_field WHERE field = \'campuses\' ' );
        $this->addSql('INSERT INTO course_info_field (field, label) VALUES (\'courseEvaluationCts\',  \'Contenu & Activités / Evaluations CT\')' );
    }
}
