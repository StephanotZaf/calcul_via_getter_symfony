<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220324063834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE grade ADD COLUMN number INTEGER NOT NULL');
        $this->addSql('DROP INDEX IDX_A6BCF3DE6AB213CC');
        $this->addSql('DROP INDEX IDX_A6BCF3DEFE19A1A8');
        $this->addSql('CREATE TEMPORARY TABLE __temp__personnel AS SELECT id, grade_id, lieu_id, first_name, last_name FROM personnel');
        $this->addSql('DROP TABLE personnel');
        $this->addSql('CREATE TABLE personnel (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, grade_id INTEGER NOT NULL, lieu_id INTEGER NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, CONSTRAINT FK_A6BCF3DEFE19A1A8 FOREIGN KEY (grade_id) REFERENCES grade (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_A6BCF3DE6AB213CC FOREIGN KEY (lieu_id) REFERENCES lieu (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO personnel (id, grade_id, lieu_id, first_name, last_name) SELECT id, grade_id, lieu_id, first_name, last_name FROM __temp__personnel');
        $this->addSql('DROP TABLE __temp__personnel');
        $this->addSql('CREATE INDEX IDX_A6BCF3DE6AB213CC ON personnel (lieu_id)');
        $this->addSql('CREATE INDEX IDX_A6BCF3DEFE19A1A8 ON personnel (grade_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__grade AS SELECT id, name, code FROM grade');
        $this->addSql('DROP TABLE grade');
        $this->addSql('CREATE TABLE grade (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(10) NOT NULL)');
        $this->addSql('INSERT INTO grade (id, name, code) SELECT id, name, code FROM __temp__grade');
        $this->addSql('DROP TABLE __temp__grade');
        $this->addSql('DROP INDEX IDX_A6BCF3DEFE19A1A8');
        $this->addSql('DROP INDEX IDX_A6BCF3DE6AB213CC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__personnel AS SELECT id, grade_id, lieu_id, first_name, last_name FROM personnel');
        $this->addSql('DROP TABLE personnel');
        $this->addSql('CREATE TABLE personnel (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, grade_id INTEGER NOT NULL, lieu_id INTEGER NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO personnel (id, grade_id, lieu_id, first_name, last_name) SELECT id, grade_id, lieu_id, first_name, last_name FROM __temp__personnel');
        $this->addSql('DROP TABLE __temp__personnel');
        $this->addSql('CREATE INDEX IDX_A6BCF3DEFE19A1A8 ON personnel (grade_id)');
        $this->addSql('CREATE INDEX IDX_A6BCF3DE6AB213CC ON personnel (lieu_id)');
    }
}
