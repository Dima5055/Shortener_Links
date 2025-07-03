<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250703113515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__links AS SELECT id, original_url, short_url, creation_date, last_use_date, numbers_of_click, disposable, expiration_date FROM links');
        $this->addSql('DROP TABLE links');
        $this->addSql('CREATE TABLE links (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, original_url VARCHAR(255) NOT NULL, short_url VARCHAR(255) NOT NULL, creation_date DATETIME NOT NULL, last_use_date DATETIME NOT NULL, numbers_of_click INTEGER NOT NULL, disposable BOOLEAN DEFAULT NULL, expiration_date VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO links (id, original_url, short_url, creation_date, last_use_date, numbers_of_click, disposable, expiration_date) SELECT id, original_url, short_url, creation_date, last_use_date, numbers_of_click, disposable, expiration_date FROM __temp__links');
        $this->addSql('DROP TABLE __temp__links');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__links AS SELECT id, original_url, short_url, creation_date, last_use_date, numbers_of_click, disposable, expiration_date FROM links');
        $this->addSql('DROP TABLE links');
        $this->addSql('CREATE TABLE links (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, original_url VARCHAR(255) NOT NULL, short_url VARCHAR(255) NOT NULL, creation_date DATETIME NOT NULL, last_use_date DATETIME NOT NULL, numbers_of_click INTEGER NOT NULL, disposable BOOLEAN DEFAULT NULL, expiration_date DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO links (id, original_url, short_url, creation_date, last_use_date, numbers_of_click, disposable, expiration_date) SELECT id, original_url, short_url, creation_date, last_use_date, numbers_of_click, disposable, expiration_date FROM __temp__links');
        $this->addSql('DROP TABLE __temp__links');
    }
}
