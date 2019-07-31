<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190730110755 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE commission (id INT AUTO_INCREMENT NOT NULL, operation_id INT NOT NULL, etat INT NOT NULL, systeme INT NOT NULL, partenaire INT NOT NULL, partenaireretrait INT NOT NULL, UNIQUE INDEX UNIQ_1C65015844AC3583 (operation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE codeoperation (id INT AUTO_INCREMENT NOT NULL, operation_id INT NOT NULL, client_id INT NOT NULL, code INT NOT NULL, UNIQUE INDEX UNIQ_CEC09B2644AC3583 (operation_id), UNIQUE INDEX UNIQ_CEC09B2619EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE typeoperation (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compte (id INT AUTO_INCREMENT NOT NULL, partenaire_id INT NOT NULL, numerocompte INT NOT NULL, solde INT NOT NULL, UNIQUE INDEX UNIQ_CFF6526098DE13AC (partenaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, partenaire_id INT DEFAULT NULL, login VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telephone INT NOT NULL, statut VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1D1C63B3AA08CB10 (login), INDEX IDX_1D1C63B398DE13AC (partenaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partenaire (id INT AUTO_INCREMENT NOT NULL, raisonsociale VARCHAR(255) NOT NULL, ninea VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nomenvoyeur VARCHAR(255) NOT NULL, prenomenvoyeur VARCHAR(255) NOT NULL, telephoneenvoyeur VARCHAR(255) NOT NULL, ncienvoyeur INT NOT NULL, nombeneficiaire VARCHAR(255) NOT NULL, prenombeneficiaire VARCHAR(255) NOT NULL, telephonebeneficiaire INT NOT NULL, ncibeneficiaire INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operation (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, libelle_id INT NOT NULL, date DATETIME NOT NULL, montant INT NOT NULL, frais INT NOT NULL, INDEX IDX_1981A66DFB88E14F (utilisateur_id), INDEX IDX_1981A66D25DD318D (libelle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE depot (id INT AUTO_INCREMENT NOT NULL, compte_id INT NOT NULL, montant INT NOT NULL, date DATETIME NOT NULL, INDEX IDX_47948BBCF2C56620 (compte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commission ADD CONSTRAINT FK_1C65015844AC3583 FOREIGN KEY (operation_id) REFERENCES operation (id)');
        $this->addSql('ALTER TABLE codeoperation ADD CONSTRAINT FK_CEC09B2644AC3583 FOREIGN KEY (operation_id) REFERENCES operation (id)');
        $this->addSql('ALTER TABLE codeoperation ADD CONSTRAINT FK_CEC09B2619EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF6526098DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B398DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66D25DD318D FOREIGN KEY (libelle_id) REFERENCES typeoperation (id)');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBCF2C56620 FOREIGN KEY (compte_id) REFERENCES compte (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66D25DD318D');
        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBCF2C56620');
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66DFB88E14F');
        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF6526098DE13AC');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B398DE13AC');
        $this->addSql('ALTER TABLE codeoperation DROP FOREIGN KEY FK_CEC09B2619EB6921');
        $this->addSql('ALTER TABLE commission DROP FOREIGN KEY FK_1C65015844AC3583');
        $this->addSql('ALTER TABLE codeoperation DROP FOREIGN KEY FK_CEC09B2644AC3583');
        $this->addSql('DROP TABLE commission');
        $this->addSql('DROP TABLE codeoperation');
        $this->addSql('DROP TABLE typeoperation');
        $this->addSql('DROP TABLE compte');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE partenaire');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE operation');
        $this->addSql('DROP TABLE depot');
    }
}
