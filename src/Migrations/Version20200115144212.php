<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200115144212 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE course_info ADD teaching_cm_dist DOUBLE PRECISION DEFAULT NULL, ADD teaching_td_dist DOUBLE PRECISION DEFAULT NULL, ADD teaching_other_dist DOUBLE PRECISION DEFAULT NULL, ADD teaching_other_type_distant VARCHAR(65) DEFAULT NULL');
        $this->addSql('DROP INDEX uniq_725585dc5bf54558 ON course_info_field');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8E4ECE2E5BF54558 ON course_info_field (field)');
        $this->addSql('DROP INDEX uniq_725585dcea750e8 ON course_info_field');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8E4ECE2EEA750E8 ON course_info_field (`label`)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE course_info DROP teaching_cm_dist, DROP teaching_td_dist, DROP teaching_other_dist, DROP teaching_other_type_distant');
        $this->addSql('DROP INDEX uniq_8e4ece2e5bf54558 ON course_info_field');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_725585DC5BF54558 ON course_info_field (field)');
        $this->addSql('DROP INDEX uniq_8e4ece2eea750e8 ON course_info_field');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_725585DCEA750E8 ON course_info_field (`label`)');
    }
}
