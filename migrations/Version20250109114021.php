<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250109114021 extends AbstractMigration
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
        $this->addSql('CREATE TABLE ingredient (id SERIAL NOT NULL, recipe_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, quantity VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6BAF787059D8A214 ON ingredient (recipe_id)');
        $this->addSql('CREATE TABLE instruction (id SERIAL NOT NULL, recipe_id INT DEFAULT NULL, content TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7BBAE15659D8A214 ON instruction (recipe_id)');
        $this->addSql('CREATE TABLE recipe (id SERIAL NOT NULL, cuisine_id INT DEFAULT NULL, category_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, description TEXT NOT NULL, servings INT NOT NULL, cooking_time INT NOT NULL, prep_time INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DA88B137ED4BAC14 ON recipe (cuisine_id)');
        $this->addSql('CREATE INDEX IDX_DA88B13712469DE2 ON recipe (category_id)');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT FK_6BAF787059D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE instruction ADD CONSTRAINT FK_7BBAE15659D8A214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B137ED4BAC14 FOREIGN KEY (cuisine_id) REFERENCES cuisine (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B13712469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE ingredient DROP CONSTRAINT FK_6BAF787059D8A214');
        $this->addSql('ALTER TABLE instruction DROP CONSTRAINT FK_7BBAE15659D8A214');
        $this->addSql('ALTER TABLE recipe DROP CONSTRAINT FK_DA88B137ED4BAC14');
        $this->addSql('ALTER TABLE recipe DROP CONSTRAINT FK_DA88B13712469DE2');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE cuisine');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE instruction');
        $this->addSql('DROP TABLE recipe');
    }
}
