<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200226100431 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE learning_achievement DROP FOREIGN KEY FK_B4A2459729B8CE33');
        $this->addSql('ALTER TABLE learning_achievement ADD CONSTRAINT FK_B4A2459729B8CE33 FOREIGN KEY (course_critical_achievement_learning_achievement) REFERENCES course_critical_achievement (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE learning_achievement DROP FOREIGN KEY FK_B4A2459729B8CE33');
        $this->addSql('ALTER TABLE learning_achievement ADD CONSTRAINT FK_B4A2459729B8CE33 FOREIGN KEY (course_critical_achievement_learning_achievement) REFERENCES learning_achievement (id)');
    }
}
