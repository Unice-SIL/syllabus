<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200217152723 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE campus ADD synchronized TINYINT(1) NOT NULL, CHANGE code code VARCHAR(50) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX code_source_on_campus_UNIQUE ON campus (code, source)');
        $this->addSql('ALTER TABLE structure ADD synchronized TINYINT(1) NOT NULL, CHANGE code code VARCHAR(50) DEFAULT NULL, CHANGE source source VARCHAR(50) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX code_source_on_structure_UNIQUE ON structure (code, source)');
        $this->addSql('DROP INDEX code_UNIQUE ON course');
        $this->addSql('ALTER TABLE course ADD title VARCHAR(150) NOT NULL, ADD synchronized TINYINT(1) NOT NULL, CHANGE code code VARCHAR(50) DEFAULT NULL, CHANGE source source VARCHAR(50) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX code_source_on_course_UNIQUE ON course (code, source)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX code_source_on_campus_UNIQUE ON campus');
        $this->addSql('ALTER TABLE campus DROP synchronized, CHANGE code code VARCHAR(50) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('DROP INDEX code_source_on_course_UNIQUE ON course');
        $this->addSql('ALTER TABLE course DROP title, DROP synchronized, CHANGE code code CHAR(50) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE source source VARCHAR(50) CHARACTER SET utf8 DEFAULT \'import effectué avant la mise en place de ce champ\' COLLATE `utf8_unicode_ci`');
        $this->addSql('CREATE UNIQUE INDEX code_UNIQUE ON course (code)');
        $this->addSql('DROP INDEX code_source_on_structure_UNIQUE ON structure');
        $this->addSql('ALTER TABLE structure DROP synchronized, CHANGE code code VARCHAR(50) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, CHANGE source source VARCHAR(50) CHARACTER SET utf8 DEFAULT \'import effectué avant la mise en place de ce champ\' COLLATE `utf8_unicode_ci`');

    }
}
