<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250109110752 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recipe ADD cuisine_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE recipe DROP cuisine');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B137ED4BAC14 FOREIGN KEY (cuisine_id) REFERENCES cuisine (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_DA88B137ED4BAC14 ON recipe (cuisine_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE recipe DROP CONSTRAINT FK_DA88B137ED4BAC14');
        $this->addSql('DROP INDEX IDX_DA88B137ED4BAC14');
        $this->addSql('ALTER TABLE recipe ADD cuisine VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE recipe DROP cuisine_id');
    }
}
