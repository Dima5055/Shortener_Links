<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250703070520 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__links AS SELECT id, original_url, short_url, creation_date, last_use_date, numbers_of_click FROM links');
        $this->addSql('DROP TABLE links');
        $this->addSql('CREATE TABLE links (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, original_url VARCHAR(255) NOT NULL, short_url VARCHAR(255) NOT NULL, creation_date DATETIME NOT NULL, last_use_date DATETIME NOT NULL, numbers_of_click INTEGER NOT NULL, disposable BOOLEAN NOT NULL, expiration_date DATETIME NOT NULL)');
        $this->addSql('INSERT INTO links (id, original_url, short_url, creation_date, last_use_date, numbers_of_click) SELECT id, original_url, short_url, creation_date, last_use_date, numbers_of_click FROM __temp__links');
        $this->addSql('DROP TABLE __temp__links');
        $this->addSql('CREATE TEMPORARY TABLE __temp__messenger_messages AS SELECT id, body, headers, queue_name, created_at, available_at, delivered_at FROM messenger_messages');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO messenger_messages (id, body, headers, queue_name, created_at, available_at, delivered_at) SELECT id, body, headers, queue_name, created_at, available_at, delivered_at FROM __temp__messenger_messages');
        $this->addSql('DROP TABLE __temp__messenger_messages');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__links AS SELECT id, original_url, short_url, creation_date, last_use_date, numbers_of_click FROM links');
        $this->addSql('DROP TABLE links');
        $this->addSql('CREATE TABLE links (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, original_url VARCHAR(255) NOT NULL, short_url VARCHAR(255) NOT NULL, creation_date DATE NOT NULL, last_use_date DATE NOT NULL, numbers_of_click INTEGER NOT NULL)');
        $this->addSql('INSERT INTO links (id, original_url, short_url, creation_date, last_use_date, numbers_of_click) SELECT id, original_url, short_url, creation_date, last_use_date, numbers_of_click FROM __temp__links');
        $this->addSql('DROP TABLE __temp__links');
        $this->addSql('CREATE TEMPORARY TABLE __temp__messenger_messages AS SELECT id, body, headers, queue_name, created_at, available_at, delivered_at FROM messenger_messages');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO messenger_messages (id, body, headers, queue_name, created_at, available_at, delivered_at) SELECT id, body, headers, queue_name, created_at, available_at, delivered_at FROM __temp__messenger_messages');
        $this->addSql('DROP TABLE __temp__messenger_messages');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }
}
