<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251013205429 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE venture DROP CONSTRAINT FK_FA597E79EA9FDD75');
        $this->addSql('DROP INDEX uniq_fa597e79ea9fdd75');
        $this->addSql('ALTER TABLE venture ADD CONSTRAINT FK_FA597E79EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_FA597E79EA9FDD75 ON venture (media_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE venture DROP CONSTRAINT fk_fa597e79ea9fdd75');
        $this->addSql('DROP INDEX IDX_FA597E79EA9FDD75');
        $this->addSql('ALTER TABLE venture ADD CONSTRAINT fk_fa597e79ea9fdd75 FOREIGN KEY (media_id) REFERENCES media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_fa597e79ea9fdd75 ON venture (media_id)');
    }
}
