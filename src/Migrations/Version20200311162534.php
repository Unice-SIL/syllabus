<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200311162534 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE course_translations (id INT AUTO_INCREMENT NOT NULL, locale VARCHAR(8) NOT NULL, object_class VARCHAR(255) NOT NULL, field VARCHAR(32) NOT NULL, foreign_key VARCHAR(64) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX course_translation_idx (locale, object_class, field, foreign_key), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ext_translations (id INT AUTO_INCREMENT NOT NULL, locale VARCHAR(8) NOT NULL, object_class VARCHAR(255) NOT NULL, field VARCHAR(32) NOT NULL, foreign_key VARCHAR(64) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX translations_lookup_idx (locale, object_class, foreign_key), UNIQUE INDEX lookup_unique_idx (locale, object_class, field, foreign_key), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB ROW_FORMAT = DYNAMIC');
        $this->addSql('CREATE TABLE lexik_trans_unit (id INT AUTO_INCREMENT NOT NULL, key_name VARCHAR(255) NOT NULL, domain VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX key_domain_idx (key_name, domain), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lexik_translation_file (id INT AUTO_INCREMENT NOT NULL, domain VARCHAR(255) NOT NULL, locale VARCHAR(10) NOT NULL, extention VARCHAR(10) NOT NULL, path VARCHAR(255) NOT NULL, hash VARCHAR(255) NOT NULL, UNIQUE INDEX hash_idx (hash), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lexik_trans_unit_translations (id INT AUTO_INCREMENT NOT NULL, file_id INT DEFAULT NULL, trans_unit_id INT DEFAULT NULL, locale VARCHAR(10) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, modified_manually TINYINT(1) NOT NULL, INDEX IDX_B0AA394493CB796C (file_id), INDEX IDX_B0AA3944C3C583C9 (trans_unit_id), UNIQUE INDEX trans_unit_locale_idx (trans_unit_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lexik_trans_unit_translations ADD CONSTRAINT FK_B0AA394493CB796C FOREIGN KEY (file_id) REFERENCES lexik_translation_file (id)');
        $this->addSql('ALTER TABLE lexik_trans_unit_translations ADD CONSTRAINT FK_B0AA3944C3C583C9 FOREIGN KEY (trans_unit_id) REFERENCES lexik_trans_unit (id)');
        $this->addSql('ALTER TABLE language ADD locale VARCHAR(10) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX locale_on_language_UNIQUE ON language (locale)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lexik_trans_unit_translations DROP FOREIGN KEY FK_B0AA3944C3C583C9');
        $this->addSql('ALTER TABLE lexik_trans_unit_translations DROP FOREIGN KEY FK_B0AA394493CB796C');
        $this->addSql('DROP TABLE course_translations');
        $this->addSql('DROP TABLE ext_translations');
        $this->addSql('DROP TABLE lexik_trans_unit');
        $this->addSql('DROP TABLE lexik_translation_file');
        $this->addSql('DROP TABLE lexik_trans_unit_translations');
        $this->addSql('DROP INDEX locale_on_language_UNIQUE ON language');
        $this->addSql('ALTER TABLE language DROP locale');
    }
}
