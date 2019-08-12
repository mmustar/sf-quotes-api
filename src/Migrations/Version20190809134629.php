<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190809134629 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_6B71CBF47E3C61F9');
        $this->addSql('CREATE TEMPORARY TABLE __temp__quote AS SELECT id, owner_id, value FROM quote');
        $this->addSql('DROP TABLE quote');
        $this->addSql('CREATE TABLE quote (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, value VARCHAR(150) NOT NULL COLLATE BINARY, CONSTRAINT FK_6B71CBF47E3C61F9 FOREIGN KEY (owner_id) REFERENCES quote_owner (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO quote (id, owner_id, value) SELECT id, owner_id, value FROM __temp__quote');
        $this->addSql('DROP TABLE __temp__quote');
        $this->addSql('CREATE INDEX IDX_6B71CBF47E3C61F9 ON quote (owner_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6B71CBF41D775834 ON quote (value)');
        $this->addSql('DROP INDEX UNIQ_C29F6B1D91657DAE');
        $this->addSql('CREATE TEMPORARY TABLE __temp__quote_owner AS SELECT id, fullname FROM quote_owner');
        $this->addSql('DROP TABLE quote_owner');
        $this->addSql('CREATE TABLE quote_owner (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, fullname VARCHAR(30) NOT NULL)');
        $this->addSql('INSERT INTO quote_owner (id, fullname) SELECT id, fullname FROM __temp__quote_owner');
        $this->addSql('DROP TABLE __temp__quote_owner');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C29F6B1D91657DAE ON quote_owner (fullname)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX UNIQ_6B71CBF41D775834');
        $this->addSql('DROP INDEX IDX_6B71CBF47E3C61F9');
        $this->addSql('CREATE TEMPORARY TABLE __temp__quote AS SELECT id, owner_id, value FROM quote');
        $this->addSql('DROP TABLE quote');
        $this->addSql('CREATE TABLE quote (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, value VARCHAR(150) NOT NULL)');
        $this->addSql('INSERT INTO quote (id, owner_id, value) SELECT id, owner_id, value FROM __temp__quote');
        $this->addSql('DROP TABLE __temp__quote');
        $this->addSql('CREATE INDEX IDX_6B71CBF47E3C61F9 ON quote (owner_id)');
        $this->addSql('DROP INDEX UNIQ_C29F6B1D91657DAE');
        $this->addSql('CREATE TEMPORARY TABLE __temp__quote_owner AS SELECT id, fullname FROM quote_owner');
        $this->addSql('DROP TABLE quote_owner');
        $this->addSql('CREATE TABLE quote_owner (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, fullname VARCHAR(150) NOT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO quote_owner (id, fullname) SELECT id, fullname FROM __temp__quote_owner');
        $this->addSql('DROP TABLE __temp__quote_owner');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C29F6B1D91657DAE ON quote_owner (fullname)');
    }
}
