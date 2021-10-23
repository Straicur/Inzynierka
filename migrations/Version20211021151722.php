<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211021151722 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Audiobook (audiobook_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, category_id INTEGER DEFAULT NULL, title VARCHAR(180) NOT NULL, year INTEGER NOT NULL, publisher VARCHAR(255) NOT NULL, comments VARCHAR(255) NOT NULL, duration VARCHAR(255) NOT NULL, parts INTEGER NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6A9136CB2B36786B ON Audiobook (title)');
        $this->addSql('CREATE INDEX IDX_6A9136CB12469DE2 ON Audiobook (category_id)');
        $this->addSql('CREATE TABLE AudiobookInfo (audiobook_info_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_info_id INTEGER DEFAULT NULL, part_nr INTEGER NOT NULL, ended_Tim TIME NOT NULL, watching_date DATE NOT NULL)');
        $this->addSql('CREATE INDEX IDX_2F2C5D51586DFF2 ON AudiobookInfo (user_info_id)');
        $this->addSql('CREATE TABLE Category (category_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, institution_id INTEGER DEFAULT NULL, name VARCHAR(180) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FF3A7B975E237E06 ON Category (name)');
        $this->addSql('CREATE INDEX IDX_FF3A7B9710405986 ON Category (institution_id)');
        $this->addSql('CREATE TABLE MyList (audiobook_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3378B295A76ED395 ON MyList (user_id)');
        $this->addSql('CREATE TABLE UserInfo (audiobook_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_34B0844EA76ED395 ON UserInfo (user_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__adminPassword AS SELECT admin_id, admin_password, created_at FROM adminPassword');
        $this->addSql('DROP TABLE adminPassword');
        $this->addSql('CREATE TABLE adminPassword (admin_id INTEGER NOT NULL, admin_password VARCHAR(513) NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, PRIMARY KEY(admin_id), CONSTRAINT FK_CFBE0C82642B8210 FOREIGN KEY (admin_id) REFERENCES AdminUser (admin_id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO adminPassword (admin_id, admin_password, created_at) SELECT admin_id, admin_password, created_at FROM __temp__adminPassword');
        $this->addSql('DROP TABLE __temp__adminPassword');
        $this->addSql('DROP INDEX IDX_943CB15B10405986');
        $this->addSql('CREATE TEMPORARY TABLE __temp__AdminUser AS SELECT admin_id, institution_id, login, created_at FROM AdminUser');
        $this->addSql('DROP TABLE AdminUser');
        $this->addSql('CREATE TABLE AdminUser (admin_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, institution_id INTEGER DEFAULT NULL, login VARCHAR(255) NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, CONSTRAINT FK_943CB15B10405986 FOREIGN KEY (institution_id) REFERENCES Institution (institution_id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO AdminUser (admin_id, institution_id, login, created_at) SELECT admin_id, institution_id, login, created_at FROM __temp__AdminUser');
        $this->addSql('DROP TABLE __temp__AdminUser');
        $this->addSql('CREATE INDEX IDX_943CB15B10405986 ON AdminUser (institution_id)');
        $this->addSql('DROP INDEX IDX_5F37A13B642B8210');
        $this->addSql('CREATE TEMPORARY TABLE __temp__token AS SELECT token_id, admin_id, token, created_at, active_to, active FROM token');
        $this->addSql('DROP TABLE token');
        $this->addSql('CREATE TABLE token (token_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, admin_id INTEGER DEFAULT NULL, token VARCHAR(255) NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, active_to DATETIME NOT NULL, active BOOLEAN NOT NULL, CONSTRAINT FK_9EF68E3F642B8210 FOREIGN KEY (admin_id) REFERENCES AdminUser (admin_id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO token (token_id, admin_id, token, created_at, active_to, active) SELECT token_id, admin_id, token, created_at, active_to, active FROM __temp__token');
        $this->addSql('DROP TABLE __temp__token');
        $this->addSql('CREATE INDEX IDX_9EF68E3F642B8210 ON token (admin_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74');
        $this->addSql('DROP INDEX IDX_8D93D64910405986');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, institution_id, email, roles, password, isVerified FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (user_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, institution_id INTEGER DEFAULT NULL, email VARCHAR(180) NOT NULL COLLATE BINARY, roles CLOB NOT NULL COLLATE BINARY --(DC2Type:json)
        , password VARCHAR(255) NOT NULL COLLATE BINARY, isVerified BOOLEAN NOT NULL, CONSTRAINT FK_2DA1797710405986 FOREIGN KEY (institution_id) REFERENCES Institution (institution_id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user (user_id, institution_id, email, roles, password, isVerified) SELECT id, institution_id, email, roles, password, isVerified FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2DA17977E7927C74 ON user (email)');
        $this->addSql('CREATE INDEX IDX_2DA1797710405986 ON user (institution_id)');
        $this->addSql('DROP INDEX IDX_B952B2EDBF396750');
        $this->addSql('CREATE TEMPORARY TABLE __temp__userToken AS SELECT token_id, id, token, created_at, active_to, active FROM userToken');
        $this->addSql('DROP TABLE userToken');
        $this->addSql('CREATE TABLE userToken (token_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, token VARCHAR(255) NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, active_to DATETIME NOT NULL, active BOOLEAN NOT NULL, CONSTRAINT FK_3BA3304EA76ED395 FOREIGN KEY (user_id) REFERENCES User (user_id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO userToken (token_id, user_id, token, created_at, active_to, active) SELECT token_id, id, token, created_at, active_to, active FROM __temp__userToken');
        $this->addSql('DROP TABLE __temp__userToken');
        $this->addSql('CREATE INDEX IDX_3BA3304EA76ED395 ON userToken (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE Audiobook');
        $this->addSql('DROP TABLE AudiobookInfo');
        $this->addSql('DROP TABLE Category');
        $this->addSql('DROP TABLE MyList');
        $this->addSql('DROP TABLE UserInfo');
        $this->addSql('DROP INDEX IDX_943CB15B10405986');
        $this->addSql('CREATE TEMPORARY TABLE __temp__AdminUser AS SELECT admin_id, institution_id, login, created_at FROM AdminUser');
        $this->addSql('DROP TABLE AdminUser');
        $this->addSql('CREATE TABLE AdminUser (admin_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, institution_id INTEGER DEFAULT NULL, login VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO AdminUser (admin_id, institution_id, login, created_at) SELECT admin_id, institution_id, login, created_at FROM __temp__AdminUser');
        $this->addSql('DROP TABLE __temp__AdminUser');
        $this->addSql('CREATE INDEX IDX_943CB15B10405986 ON AdminUser (institution_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__AdminPassword AS SELECT admin_id, admin_password, created_at FROM AdminPassword');
        $this->addSql('DROP TABLE AdminPassword');
        $this->addSql('CREATE TABLE AdminPassword (admin_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, admin_password VARCHAR(513) NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO AdminPassword (admin_id, admin_password, created_at) SELECT admin_id, admin_password, created_at FROM __temp__AdminPassword');
        $this->addSql('DROP TABLE __temp__AdminPassword');
        $this->addSql('DROP INDEX IDX_9EF68E3F642B8210');
        $this->addSql('CREATE TEMPORARY TABLE __temp__Token AS SELECT token_id, admin_id, token, created_at, active_to, active FROM Token');
        $this->addSql('DROP TABLE Token');
        $this->addSql('CREATE TABLE Token (token_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, admin_id INTEGER DEFAULT NULL, token VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, active_to DATETIME NOT NULL, active BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO Token (token_id, admin_id, token, created_at, active_to, active) SELECT token_id, admin_id, token, created_at, active_to, active FROM __temp__Token');
        $this->addSql('DROP TABLE __temp__Token');
        $this->addSql('CREATE INDEX IDX_5F37A13B642B8210 ON Token (admin_id)');
        $this->addSql('DROP INDEX UNIQ_2DA17977E7927C74');
        $this->addSql('DROP INDEX IDX_2DA1797710405986');
        $this->addSql('CREATE TEMPORARY TABLE __temp__User AS SELECT user_id, institution_id, email, roles, password, isVerified FROM User');
        $this->addSql('DROP TABLE User');
        $this->addSql('CREATE TABLE User (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, institution_id INTEGER DEFAULT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, isVerified BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO User (id, institution_id, email, roles, password, isVerified) SELECT user_id, institution_id, email, roles, password, isVerified FROM __temp__User');
        $this->addSql('DROP TABLE __temp__User');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON User (email)');
        $this->addSql('CREATE INDEX IDX_8D93D64910405986 ON User (institution_id)');
        $this->addSql('DROP INDEX IDX_3BA3304EA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__UserToken AS SELECT token_id, user_id, token, created_at, active_to, active FROM UserToken');
        $this->addSql('DROP TABLE UserToken');
        $this->addSql('CREATE TABLE UserToken (token_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, token VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, active_to DATETIME NOT NULL, active BOOLEAN NOT NULL, id INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO UserToken (token_id, id, token, created_at, active_to, active) SELECT token_id, user_id, token, created_at, active_to, active FROM __temp__UserToken');
        $this->addSql('DROP TABLE __temp__UserToken');
        $this->addSql('CREATE INDEX IDX_B952B2EDBF396750 ON UserToken (id)');
    }
}
