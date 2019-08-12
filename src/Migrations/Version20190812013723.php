<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190812013723 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE codeoperation DROP FOREIGN KEY FK_CEC09B2619EB6921');
        $this->addSql('ALTER TABLE codeoperation DROP FOREIGN KEY FK_CEC09B2644AC3583');
        $this->addSql('ALTER TABLE commission DROP FOREIGN KEY FK_1C65015844AC3583');
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66D25DD318D');
        $this->addSql('CREATE TABLE envoi (id INT AUTO_INCREMENT NOT NULL, dateenvoi DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE codeoperation');
        $this->addSql('DROP TABLE commission');
        $this->addSql('DROP TABLE operation');
        $this->addSql('DROP TABLE typeoperation');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nomenvoyeur VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, prenomenvoyeur VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, telephoneenvoyeur VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ncienvoyeur INT NOT NULL, nombeneficiaire VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, prenombeneficiaire VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, telephonebeneficiaire INT NOT NULL, ncibeneficiaire INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE codeoperation (id INT AUTO_INCREMENT NOT NULL, operation_id INT NOT NULL, client_id INT NOT NULL, code INT NOT NULL, UNIQUE INDEX UNIQ_CEC09B2644AC3583 (operation_id), UNIQUE INDEX UNIQ_CEC09B2619EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE commission (id INT AUTO_INCREMENT NOT NULL, operation_id INT NOT NULL, etat INT NOT NULL, systeme INT NOT NULL, partenaire INT NOT NULL, partenaireretrait INT NOT NULL, UNIQUE INDEX UNIQ_1C65015844AC3583 (operation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE operation (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, libelle_id INT NOT NULL, date DATETIME NOT NULL, montant INT NOT NULL, frais INT NOT NULL, INDEX IDX_1981A66DFB88E14F (utilisateur_id), INDEX IDX_1981A66D25DD318D (libelle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE typeoperation (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE codeoperation ADD CONSTRAINT FK_CEC09B2619EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE codeoperation ADD CONSTRAINT FK_CEC09B2644AC3583 FOREIGN KEY (operation_id) REFERENCES operation (id)');
        $this->addSql('ALTER TABLE commission ADD CONSTRAINT FK_1C65015844AC3583 FOREIGN KEY (operation_id) REFERENCES operation (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66D25DD318D FOREIGN KEY (libelle_id) REFERENCES typeoperation (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('DROP TABLE envoi');
    }
}
