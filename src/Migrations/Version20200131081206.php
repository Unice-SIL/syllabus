<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200131081206 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bak_course_evaluation_ct DROP FOREIGN KEY FK_61B9EA715548C414');
        $this->addSql('ALTER TABLE bak_course_section_activity DROP FOREIGN KEY FK_B95D28E67C1ADF9');

        $this->addSql('DROP INDEX fk_course_evaluation_ct_activity1_idx ON bak_course_evaluation_ct');
        $this->addSql('DROP INDEX fk_course_evaluation_ct_course_info1_idx ON bak_course_evaluation_ct');
        $this->addSql('DROP INDEX fk_course_section_activity_activity1_idx ON bak_course_section_activity');
        $this->addSql('DROP INDEX fk_course_section_activity_course_section1_idx ON bak_course_section_activity');

        $this->addSql('CREATE INDEX IDX_613A661781C06096 ON bak_course_evaluation_ct (activity_id)');
        $this->addSql('CREATE INDEX IDX_613A66175548C414 ON bak_course_evaluation_ct (course_info_id)');
        $this->addSql('CREATE INDEX IDX_16809AA981C06096 ON bak_course_section_activity (activity_id)');
        $this->addSql('CREATE INDEX IDX_16809AA97C1ADF9 ON bak_course_section_activity (course_section_id)');

        $this->addSql('ALTER TABLE bak_course_evaluation_ct ADD CONSTRAINT FK_613A661781C06096 FOREIGN KEY (activity_id) REFERENCES bak_activity (id)');
        $this->addSql('ALTER TABLE bak_course_evaluation_ct ADD CONSTRAINT FK_61B9EA715548C414 FOREIGN KEY (course_info_id) REFERENCES course_info (id)');
        $this->addSql('ALTER TABLE bak_course_section_activity ADD CONSTRAINT FK_16809AA981C06096 FOREIGN KEY (activity_id) REFERENCES bak_activity (id)');
        $this->addSql('ALTER TABLE bak_course_section_activity ADD CONSTRAINT FK_B95D28E67C1ADF9 FOREIGN KEY (course_section_id) REFERENCES course_section (id)');
        $this->addSql('ALTER TABLE course_section_activity ADD evaluable TINYINT(1) NOT NULL, ADD evaluation_ct TINYINT(1) NOT NULL');

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bak_course_evaluation_ct DROP FOREIGN KEY FK_613A661781C06096');
        $this->addSql('ALTER TABLE bak_course_evaluation_ct DROP FOREIGN KEY FK_613A66175548C414');
        $this->addSql('ALTER TABLE bak_course_section_activity DROP FOREIGN KEY FK_16809AA981C06096');
        $this->addSql('ALTER TABLE bak_course_section_activity DROP FOREIGN KEY FK_16809AA97C1ADF9');
        $this->addSql('ALTER TABLE course_section_activity DROP FOREIGN KEY FK_B95D28E67C1ADF9');

        $this->addSql('DROP INDEX idx_613a661781c06096 ON bak_course_evaluation_ct');
        $this->addSql('DROP INDEX idx_613a66175548c414 ON bak_course_evaluation_ct');
        $this->addSql('DROP INDEX idx_16809aa981c06096 ON bak_course_section_activity');
        $this->addSql('DROP INDEX idx_16809aa97c1adf9 ON bak_course_section_activity');

        $this->addSql('CREATE INDEX fk_course_evaluation_ct_activity1_idx ON bak_course_evaluation_ct (activity_id)');
        $this->addSql('CREATE INDEX fk_course_evaluation_ct_course_info1_idx ON bak_course_evaluation_ct (course_info_id)');
        $this->addSql('CREATE INDEX fk_course_section_activity_activity1_idx ON bak_course_section_activity (activity_id)');
        $this->addSql('CREATE INDEX fk_course_section_activity_course_section1_idx ON bak_course_section_activity (course_section_id)');

        $this->addSql('ALTER TABLE bak_course_evaluation_ct ADD CONSTRAINT FK_613A661781C06096 FOREIGN KEY (activity_id) REFERENCES bak_activity (id)');
        $this->addSql('ALTER TABLE bak_course_evaluation_ct ADD CONSTRAINT FK_613A66175548C414 FOREIGN KEY (course_info_id) REFERENCES course_info (id)');
        $this->addSql('ALTER TABLE bak_course_section_activity ADD CONSTRAINT FK_16809AA981C06096 FOREIGN KEY (activity_id) REFERENCES bak_activity (id)');
        $this->addSql('ALTER TABLE bak_course_section_activity ADD CONSTRAINT FK_16809AA97C1ADF9 FOREIGN KEY (course_section_id) REFERENCES course_section (id)');

        $this->addSql('ALTER TABLE course_section_activity DROP evaluable, DROP evaluation_ct');
    }
}
