<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200212151811 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE structure CHANGE etbId code VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE structure ADD source VARCHAR(50) DEFAULT \'import effectué avant la mise en place de ce champ\' NOT NULL');
        $this->addSql('ALTER TABLE course CHANGE etb_id code CHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE course RENAME INDEX etb_id_UNIQUE TO code_UNIQUE');
        $this->addSql('ALTER TABLE course ADD source VARCHAR(50) DEFAULT \'import effectué avant la mise en place de ce champ\' NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE course RENAME INDEX code_UNIQUE TO etb_id_UNIQUE');
        $this->addSql('ALTER TABLE course DROP source');
        $this->addSql('ALTER TABLE course CHANGE code etb_id VARCHAR(36)');
        $this->addSql('ALTER TABLE structure DROP source');
        $this->addSql('ALTER TABLE structure CHANGE code etbId VARCHAR(45)');

    }
}
