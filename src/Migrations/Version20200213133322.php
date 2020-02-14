<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200213133322 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE course_info_campus (campus_id CHAR(36) NOT NULL, courseinfo_id CHAR(36) NOT NULL, INDEX IDX_6AE1066BAF5D55E1 (campus_id), INDEX IDX_6AE1066BA80E736 (courseinfo_id), PRIMARY KEY(campus_id, courseinfo_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_info_domain (domain_id CHAR(36) NOT NULL, courseinfo_id CHAR(36) NOT NULL, INDEX IDX_50417071115F0EE5 (domain_id), INDEX IDX_50417071A80E736 (courseinfo_id), PRIMARY KEY(domain_id, courseinfo_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_info_language (language_id CHAR(36) NOT NULL, courseinfo_id CHAR(36) NOT NULL, INDEX IDX_AB015B7E82F1BAF4 (language_id), INDEX IDX_AB015B7EA80E736 (courseinfo_id), PRIMARY KEY(language_id, courseinfo_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_info_period (period_id CHAR(36) NOT NULL, courseinfo_id CHAR(36) NOT NULL, INDEX IDX_325070B4EC8B7ADE (period_id), INDEX IDX_325070B4A80E736 (courseinfo_id), PRIMARY KEY(period_id, courseinfo_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course_info_campus ADD CONSTRAINT FK_6AE1066BAF5D55E1 FOREIGN KEY (campus_id) REFERENCES campus (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_info_campus ADD CONSTRAINT FK_6AE1066BA80E736 FOREIGN KEY (courseinfo_id) REFERENCES course_info (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_info_domain ADD CONSTRAINT FK_50417071115F0EE5 FOREIGN KEY (domain_id) REFERENCES domain (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_info_domain ADD CONSTRAINT FK_50417071A80E736 FOREIGN KEY (courseinfo_id) REFERENCES course_info (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_info_language ADD CONSTRAINT FK_AB015B7E82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_info_language ADD CONSTRAINT FK_AB015B7EA80E736 FOREIGN KEY (courseinfo_id) REFERENCES course_info (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_info_period ADD CONSTRAINT FK_325070B4EC8B7ADE FOREIGN KEY (period_id) REFERENCES period (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_info_period ADD CONSTRAINT FK_325070B4A80E736 FOREIGN KEY (courseinfo_id) REFERENCES course_info (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_info DROP languages, DROP domain, DROP period');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE course_info_campus');
        $this->addSql('DROP TABLE course_info_domain');
        $this->addSql('DROP TABLE course_info_language');
        $this->addSql('DROP TABLE course_info_period');
        $this->addSql('ALTER TABLE course_info ADD languages VARCHAR(200) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, ADD domain CHAR(100) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, ADD period VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`');
    }
}
