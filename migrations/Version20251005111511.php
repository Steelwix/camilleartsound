<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251005111511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE venture (id SERIAL NOT NULL, media_id INT DEFAULT NULL, label VARCHAR(2500) DEFAULT NULL, link VARCHAR(2500) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FA597E79EA9FDD75 ON venture (media_id)');
        $this->addSql('ALTER TABLE venture ADD CONSTRAINT FK_FA597E79EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE venture DROP CONSTRAINT FK_FA597E79EA9FDD75');
        $this->addSql('DROP TABLE venture');
    }
}
