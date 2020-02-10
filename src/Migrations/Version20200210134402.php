<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200210134402 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE domain (id CHAR(36) NOT NULL, `label` VARCHAR(100) NOT NULL, obsolete TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE domain_structure (structure_id CHAR(36) NOT NULL, domain_id CHAR(36) NOT NULL, INDEX IDX_8971E5A42534008B (structure_id), INDEX IDX_8971E5A4115F0EE5 (domain_id), PRIMARY KEY(structure_id, domain_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE domain_structure ADD CONSTRAINT FK_8971E5A42534008B FOREIGN KEY (structure_id) REFERENCES structure (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE domain_structure ADD CONSTRAINT FK_8971E5A4115F0EE5 FOREIGN KEY (domain_id) REFERENCES domain (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_info DROP tem_presentation_tab_valid, DROP tem_activities_tab_valid, DROP tem_objectives_tab_valid, DROP tem_mcc_tab_valid, DROP tem_equipments_tab_valid, DROP tem_infos_tab_valid, DROP tem_closing_remarks_tab_valid');
        }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE domain_structure DROP FOREIGN KEY FK_8971E5A4115F0EE5');
        $this->addSql('DROP TABLE domain');
        $this->addSql('DROP TABLE domain_structure');
        $this->addSql('ALTER TABLE course_info ADD tem_presentation_tab_valid TINYINT(1) NOT NULL, ADD tem_activities_tab_valid TINYINT(1) NOT NULL, ADD tem_objectives_tab_valid TINYINT(1) NOT NULL, ADD tem_mcc_tab_valid TINYINT(1) NOT NULL, ADD tem_equipments_tab_valid TINYINT(1) NOT NULL, ADD tem_infos_tab_valid TINYINT(1) NOT NULL, ADD tem_closing_remarks_tab_valid TINYINT(1) NOT NULL');
    }
}
