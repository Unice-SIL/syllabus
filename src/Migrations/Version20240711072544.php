<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240711072544 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course_info_campus DROP FOREIGN KEY FK_24BA0793A80E736');
        $this->addSql('ALTER TABLE course_info_campus DROP FOREIGN KEY FK_24BA0793AF5D55E1');
        $this->addSql('ALTER TABLE course_info_campus ADD CONSTRAINT FK_24BA0793A80E736 FOREIGN KEY (courseinfo_id) REFERENCES course_info (id)');
        $this->addSql('ALTER TABLE course_info_campus ADD CONSTRAINT FK_24BA0793AF5D55E1 FOREIGN KEY (campus_id) REFERENCES campus (id)');
        $this->addSql('ALTER TABLE course_info_language DROP FOREIGN KEY FK_634E0682F1BAF4');
        $this->addSql('ALTER TABLE course_info_language DROP FOREIGN KEY FK_634E06A80E736');
        $this->addSql('ALTER TABLE course_info_language ADD CONSTRAINT FK_634E0682F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('ALTER TABLE course_info_language ADD CONSTRAINT FK_634E06A80E736 FOREIGN KEY (courseinfo_id) REFERENCES course_info (id)');
        $this->addSql('ALTER TABLE course_info_domain DROP FOREIGN KEY FK_1E1A7189A80E736');
        $this->addSql('ALTER TABLE course_info_domain DROP FOREIGN KEY FK_1E1A7189115F0EE5');
        $this->addSql('ALTER TABLE course_info_domain ADD CONSTRAINT FK_1E1A7189A80E736 FOREIGN KEY (courseinfo_id) REFERENCES course_info (id)');
        $this->addSql('ALTER TABLE course_info_domain ADD CONSTRAINT FK_1E1A7189115F0EE5 FOREIGN KEY (domain_id) REFERENCES domain (id)');
        $this->addSql('ALTER TABLE course_info_period DROP FOREIGN KEY FK_7C0B714CEC8B7ADE');
        $this->addSql('ALTER TABLE course_info_period DROP FOREIGN KEY FK_7C0B714CA80E736');
        $this->addSql('ALTER TABLE course_info_period ADD CONSTRAINT FK_7C0B714CEC8B7ADE FOREIGN KEY (period_id) REFERENCES period (id)');
        $this->addSql('ALTER TABLE course_info_period ADD CONSTRAINT FK_7C0B714CA80E736 FOREIGN KEY (courseinfo_id) REFERENCES course_info (id)');
        $this->addSql('ALTER TABLE courseinfo_level DROP FOREIGN KEY FK_5F8EE8575FB14BA7');
        $this->addSql('ALTER TABLE courseinfo_level DROP FOREIGN KEY FK_5F8EE857A80E736');
        $this->addSql('ALTER TABLE courseinfo_level ADD CONSTRAINT FK_5F8EE8575FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)');
        $this->addSql('ALTER TABLE courseinfo_level ADD CONSTRAINT FK_5F8EE857A80E736 FOREIGN KEY (courseinfo_id) REFERENCES course_info (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course_info_domain DROP FOREIGN KEY FK_1E1A7189A80E736');
        $this->addSql('ALTER TABLE course_info_domain DROP FOREIGN KEY FK_1E1A7189115F0EE5');
        $this->addSql('ALTER TABLE course_info_domain ADD CONSTRAINT FK_1E1A7189A80E736 FOREIGN KEY (courseinfo_id) REFERENCES course_info (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_info_domain ADD CONSTRAINT FK_1E1A7189115F0EE5 FOREIGN KEY (domain_id) REFERENCES domain (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_info_campus DROP FOREIGN KEY FK_24BA0793A80E736');
        $this->addSql('ALTER TABLE course_info_campus DROP FOREIGN KEY FK_24BA0793AF5D55E1');
        $this->addSql('ALTER TABLE course_info_campus ADD CONSTRAINT FK_24BA0793A80E736 FOREIGN KEY (courseinfo_id) REFERENCES course_info (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_info_campus ADD CONSTRAINT FK_24BA0793AF5D55E1 FOREIGN KEY (campus_id) REFERENCES campus (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE courseinfo_level DROP FOREIGN KEY FK_5F8EE857A80E736');
        $this->addSql('ALTER TABLE courseinfo_level DROP FOREIGN KEY FK_5F8EE8575FB14BA7');
        $this->addSql('ALTER TABLE courseinfo_level ADD CONSTRAINT FK_5F8EE857A80E736 FOREIGN KEY (courseinfo_id) REFERENCES course_info (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE courseinfo_level ADD CONSTRAINT FK_5F8EE8575FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_info_language DROP FOREIGN KEY FK_634E06A80E736');
        $this->addSql('ALTER TABLE course_info_language DROP FOREIGN KEY FK_634E0682F1BAF4');
        $this->addSql('ALTER TABLE course_info_language ADD CONSTRAINT FK_634E06A80E736 FOREIGN KEY (courseinfo_id) REFERENCES course_info (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_info_language ADD CONSTRAINT FK_634E0682F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_info_period DROP FOREIGN KEY FK_7C0B714CA80E736');
        $this->addSql('ALTER TABLE course_info_period DROP FOREIGN KEY FK_7C0B714CEC8B7ADE');
        $this->addSql('ALTER TABLE course_info_period ADD CONSTRAINT FK_7C0B714CA80E736 FOREIGN KEY (courseinfo_id) REFERENCES course_info (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_info_period ADD CONSTRAINT FK_7C0B714CEC8B7ADE FOREIGN KEY (period_id) REFERENCES period (id) ON DELETE CASCADE');
    }
}
