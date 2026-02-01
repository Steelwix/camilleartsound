<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260131185600 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE demo (id SERIAL NOT NULL, media_id INT NOT NULL, thumbnail_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D642DFA0EA9FDD75 ON demo (media_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D642DFA0FDFF2E92 ON demo (thumbnail_id)');
        $this->addSql('ALTER TABLE demo ADD CONSTRAINT FK_D642DFA0EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE demo ADD CONSTRAINT FK_D642DFA0FDFF2E92 FOREIGN KEY (thumbnail_id) REFERENCES media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE demo DROP CONSTRAINT FK_D642DFA0EA9FDD75');
        $this->addSql('ALTER TABLE demo DROP CONSTRAINT FK_D642DFA0FDFF2E92');
        $this->addSql('DROP TABLE demo');
    }
}
