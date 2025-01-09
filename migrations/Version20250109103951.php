<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250109103951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE cuisine (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE recipe ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE recipe DROP collection');
        $this->addSql('ALTER TABLE recipe ALTER description DROP NOT NULL');
        $this->addSql('ALTER TABLE recipe ALTER servings DROP NOT NULL');
        $this->addSql('ALTER TABLE recipe ALTER cooking_time DROP NOT NULL');
        $this->addSql('ALTER TABLE recipe ALTER prep_time DROP NOT NULL');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B13712469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_DA88B13712469DE2 ON recipe (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE recipe DROP CONSTRAINT FK_DA88B13712469DE2');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE cuisine');
        $this->addSql('DROP INDEX IDX_DA88B13712469DE2');
        $this->addSql('ALTER TABLE recipe ADD collection VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE recipe DROP category_id');
        $this->addSql('ALTER TABLE recipe ALTER description SET NOT NULL');
        $this->addSql('ALTER TABLE recipe ALTER servings SET NOT NULL');
        $this->addSql('ALTER TABLE recipe ALTER cooking_time SET NOT NULL');
        $this->addSql('ALTER TABLE recipe ALTER prep_time SET NOT NULL');
    }
}
