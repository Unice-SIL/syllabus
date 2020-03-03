<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200227133344 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE course_critical_achievement ADD code VARCHAR(50) DEFAULT NULL, ADD source VARCHAR(50) DEFAULT NULL, ADD synchronized TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE critical_achievement ADD code VARCHAR(50) DEFAULT NULL, ADD source VARCHAR(50) DEFAULT NULL, ADD synchronized TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE learning_achievement ADD code VARCHAR(50) DEFAULT NULL, ADD source VARCHAR(50) DEFAULT NULL, ADD synchronized TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE course_critical_achievement DROP code, DROP source, DROP synchronized');
        $this->addSql('ALTER TABLE critical_achievement DROP code, DROP source, DROP synchronized');
        $this->addSql('ALTER TABLE learning_achievement DROP code, DROP source, DROP synchronized');
    }
}
