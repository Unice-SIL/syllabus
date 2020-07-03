<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200703113120 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('INSERT INTO course_info_field (field, label) VALUES (\'campuses\', \'Présentation / Campus\'), (\'teachings\', \'Présentation / Volumes autres\');');
        $this->addSql('UPDATE course_info_field SET field=\'levels\', label=\'Présentation / Niveaux\' WHERE field=\'level\';');
        $this->addSql('UPDATE course_info_field SET field=\'domains\', label=\'Présentation / Domaines\' WHERE field=\'domains\';');
        $this->addSql('UPDATE course_info_field SET field=\'periods\', label=\'Présentation / Semestres\' WHERE field=\'periods\';');
        $this->addSql('DELETE FROM course_info_field WHERE field=\'semester\';');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DELETE FROM course_info_field WHERE field=\'campuses\';');
        $this->addSql('DELETE FROM course_info_field WHERE field=\'teachings\';');
        $this->addSql('UPDATE course_info_field SET field=\'level\', label=\'Présentation / Niveau\' WHERE field=\'levels\';');
        $this->addSql('UPDATE course_info_field SET field=\'domains\', label=\'Présentation / Domaine\' WHERE field=\'domains\';');
        $this->addSql('UPDATE course_info_field SET field=\'periods\', label=\'Présentation / Semestre\' WHERE field=\'periods\';');
        $this->addSql('INSERT INTO course_info_field (field, label) 
                            VALUES (\'semester\', \'Présentation / Semestre\');');
    }
}
