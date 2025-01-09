<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250109112240 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE ingredient_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE instruction_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE recipe_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cuisine_id_seq CASCADE');
        $this->addSql('ALTER TABLE instruction DROP CONSTRAINT fk_7bbae15659d8a214');
        $this->addSql('ALTER TABLE ingredient DROP CONSTRAINT fk_6baf787059d8a214');
        $this->addSql('ALTER TABLE recipe DROP CONSTRAINT fk_da88b13712469de2');
        $this->addSql('ALTER TABLE recipe DROP CONSTRAINT fk_da88b137ed4bac14');
        $this->addSql('DROP TABLE instruction');
        $this->addSql('DROP TABLE ingredient');
        $this->addSql('DROP TABLE cuisine');
        $this->addSql('DROP TABLE recipe');
        $this->addSql('DROP TABLE category');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE ingredient_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE instruction_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE recipe_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cuisine_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE instruction (id SERIAL NOT NULL, recipe_id INT DEFAULT NULL, step_number INT NOT NULL, content TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_7bbae15659d8a214 ON instruction (recipe_id)');
        $this->addSql('CREATE TABLE ingredient (id SERIAL NOT NULL, recipe_id INT NOT NULL, name VARCHAR(255) NOT NULL, quantity VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_6baf787059d8a214 ON ingredient (recipe_id)');
        $this->addSql('CREATE TABLE cuisine (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE recipe (id SERIAL NOT NULL, category_id INT DEFAULT NULL, cuisine_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, servings INT DEFAULT NULL, cooking_time INT DEFAULT NULL, prep_time INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_da88b137ed4bac14 ON recipe (cuisine_id)');
        $this->addSql('CREATE INDEX idx_da88b13712469de2 ON recipe (category_id)');
        $this->addSql('CREATE TABLE category (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE instruction ADD CONSTRAINT fk_7bbae15659d8a214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT fk_6baf787059d8a214 FOREIGN KEY (recipe_id) REFERENCES recipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT fk_da88b13712469de2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT fk_da88b137ed4bac14 FOREIGN KEY (cuisine_id) REFERENCES cuisine (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
