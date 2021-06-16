<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20210616140300
 * @package DoctrineMigrations
 */
final class Version20210616140300 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE activity_mode_translations CHANGE object_class object_class VARCHAR(191) NOT NULL');
        $this->addSql('INSERT INTO course_info_field (field, label) VALUES 
            (\'teachingCmDist\', \'Présentation / Volume CM (distanciel)\'), (\'teachingTdDist\', \'Présentation / Volume TD (distanciel)\');');
        $this->addSql('DELETE FROM course_info_field WHERE field IN (\'teachingOtherClass\', \'teachingOtherTypeClass\', \'teachingOtherHybridClass\',
            \'teachingOtherTypeHybridClass\', \'teachingOtherHybridDist\', \'teachingOtherTypeHybridDistant\');');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DELETE FROM course_info_field WHERE field IN (\'teachingCmDist\', \'teachingTdDist\');');
        $this->addSql('INSERT INTO course_info_field (field, label) VALUES
            (\'teachingOtherClass\', \'Présentation / Volume Autre (présentiel)\'), (\'teachingOtherTypeClass\', \'Présentation / Type volume Autre (présentiel)\'),
            (\'teachingOtherHybridClass\', \'Présentation / Volume Autre (hybride/présentiel)\'), (\'teachingOtherTypeHybridClass\', \'Présentation / Type volume Autre (hybride/présentiel)\'),
            (\'teachingOtherHybridDist\', \'Présentation / Volume Autre (hybride/à distance)\'), (\'teachingOtherTypeHybridDistant\', \'Présentation / Type volume Autre (hybride/à distance)\');');

    }
}
