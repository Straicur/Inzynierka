<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211018155107 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_943CB15B10405986');
        $this->addSql('CREATE TEMPORARY TABLE __temp__AdminUser AS SELECT admin_id, institution_id, login, created_at FROM AdminUser');
        $this->addSql('DROP TABLE AdminUser');
        $this->addSql('CREATE TABLE AdminUser (admin_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, institution_id INTEGER DEFAULT NULL, login VARCHAR(255) NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, CONSTRAINT FK_943CB15B10405986 FOREIGN KEY (institution_id) REFERENCES Institution (institution_id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO AdminUser (admin_id, institution_id, login, created_at) SELECT admin_id, institution_id, login, created_at FROM __temp__AdminUser');
        $this->addSql('DROP TABLE __temp__AdminUser');
        $this->addSql('CREATE INDEX IDX_943CB15B10405986 ON AdminUser (institution_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__adminPassword AS SELECT admin_id, admin_password, created_at FROM adminPassword');
        $this->addSql('DROP TABLE adminPassword');
        $this->addSql('CREATE TABLE adminPassword (admin_id INTEGER NOT NULL, admin_password VARCHAR(513) NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, PRIMARY KEY(admin_id), CONSTRAINT FK_7CC04777642B8210 FOREIGN KEY (admin_id) REFERENCES AdminUser (admin_id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO adminPassword (admin_id, admin_password, created_at) SELECT admin_id, admin_password, created_at FROM __temp__adminPassword');
        $this->addSql('DROP TABLE __temp__adminPassword');
        $this->addSql('DROP INDEX IDX_5F37A13B642B8210');
        $this->addSql('CREATE TEMPORARY TABLE __temp__token AS SELECT token_id, admin_id, token, created_at, active_to, active FROM token');
        $this->addSql('DROP TABLE token');
        $this->addSql('CREATE TABLE token (token_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, admin_id INTEGER DEFAULT NULL, token VARCHAR(255) NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, active_to DATETIME NOT NULL, active BOOLEAN NOT NULL, CONSTRAINT FK_5F37A13B642B8210 FOREIGN KEY (admin_id) REFERENCES AdminUser (admin_id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO token (token_id, admin_id, token, created_at, active_to, active) SELECT token_id, admin_id, token, created_at, active_to, active FROM __temp__token');
        $this->addSql('DROP TABLE __temp__token');
        $this->addSql('CREATE INDEX IDX_5F37A13B642B8210 ON token (admin_id)');
        $this->addSql('DROP INDEX IDX_8D93D64910405986');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, institution_id, email, roles, password, isVerified FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, institution_id INTEGER DEFAULT NULL, email VARCHAR(180) NOT NULL COLLATE BINARY, roles CLOB NOT NULL COLLATE BINARY --(DC2Type:json)
        , password VARCHAR(255) NOT NULL COLLATE BINARY, isVerified BOOLEAN NOT NULL, CONSTRAINT FK_8D93D64910405986 FOREIGN KEY (institution_id) REFERENCES Institution (institution_id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user (id, institution_id, email, roles, password, isVerified) SELECT id, institution_id, email, roles, password, isVerified FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE INDEX IDX_8D93D64910405986 ON user (institution_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
        $this->addSql('DROP INDEX IDX_B952B2EDBF396750');
        $this->addSql('CREATE TEMPORARY TABLE __temp__userToken AS SELECT token_id, id, token, created_at, active_to, active FROM userToken');
        $this->addSql('DROP TABLE userToken');
        $this->addSql('CREATE TABLE userToken (token_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id INTEGER DEFAULT NULL, token VARCHAR(255) NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, active_to DATETIME NOT NULL, active BOOLEAN NOT NULL, CONSTRAINT FK_B952B2EDBF396750 FOREIGN KEY (id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO userToken (token_id, id, token, created_at, active_to, active) SELECT token_id, id, token, created_at, active_to, active FROM __temp__userToken');
        $this->addSql('DROP TABLE __temp__userToken');
        $this->addSql('CREATE INDEX IDX_B952B2EDBF396750 ON userToken (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_943CB15B10405986');
        $this->addSql('CREATE TEMPORARY TABLE __temp__AdminUser AS SELECT admin_id, institution_id, login, created_at FROM AdminUser');
        $this->addSql('DROP TABLE AdminUser');
        $this->addSql('CREATE TABLE AdminUser (admin_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, institution_id INTEGER DEFAULT NULL, login VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO AdminUser (admin_id, institution_id, login, created_at) SELECT admin_id, institution_id, login, created_at FROM __temp__AdminUser');
        $this->addSql('DROP TABLE __temp__AdminUser');
        $this->addSql('CREATE INDEX IDX_943CB15B10405986 ON AdminUser (institution_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__adminPassword AS SELECT admin_id, admin_password, created_at FROM adminPassword');
        $this->addSql('DROP TABLE adminPassword');
        $this->addSql('CREATE TABLE adminPassword (admin_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, admin_password VARCHAR(513) NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO adminPassword (admin_id, admin_password, created_at) SELECT admin_id, admin_password, created_at FROM __temp__adminPassword');
        $this->addSql('DROP TABLE __temp__adminPassword');
        $this->addSql('DROP INDEX IDX_5F37A13B642B8210');
        $this->addSql('CREATE TEMPORARY TABLE __temp__token AS SELECT token_id, admin_id, token, created_at, active_to, active FROM token');
        $this->addSql('DROP TABLE token');
        $this->addSql('CREATE TABLE token (token_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, admin_id INTEGER DEFAULT NULL, token VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, active_to DATETIME NOT NULL, active BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO token (token_id, admin_id, token, created_at, active_to, active) SELECT token_id, admin_id, token, created_at, active_to, active FROM __temp__token');
        $this->addSql('DROP TABLE __temp__token');
        $this->addSql('CREATE INDEX IDX_5F37A13B642B8210 ON token (admin_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74');
        $this->addSql('DROP INDEX IDX_8D93D64910405986');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, institution_id, email, roles, password, isVerified FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, institution_id INTEGER DEFAULT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, isVerified BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO user (id, institution_id, email, roles, password, isVerified) SELECT id, institution_id, email, roles, password, isVerified FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
        $this->addSql('CREATE INDEX IDX_8D93D64910405986 ON user (institution_id)');
        $this->addSql('DROP INDEX IDX_B952B2EDBF396750');
        $this->addSql('CREATE TEMPORARY TABLE __temp__userToken AS SELECT token_id, id, token, created_at, active_to, active FROM userToken');
        $this->addSql('DROP TABLE userToken');
        $this->addSql('CREATE TABLE userToken (token_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id INTEGER DEFAULT NULL, token VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, active_to DATETIME NOT NULL, active BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO userToken (token_id, id, token, created_at, active_to, active) SELECT token_id, id, token, created_at, active_to, active FROM __temp__userToken');
        $this->addSql('DROP TABLE __temp__userToken');
        $this->addSql('CREATE INDEX IDX_B952B2EDBF396750 ON userToken (id)');
    }
}
