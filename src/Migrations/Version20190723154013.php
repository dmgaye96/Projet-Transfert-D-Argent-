<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190723154013 extends AbstractMigration
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
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nomenvoyeur VARCHAR(255) NOT NULL, prenomenvoyeur VARCHAR(255) NOT NULL, telephoneenvoyeur VARCHAR(255) NOT NULL, ncienvoyeur INT NOT NULL, nombeneficiaire VARCHAR(255) NOT NULL, prenombeneficiaire VARCHAR(255) NOT NULL, telephonebeneficiaire INT NOT NULL, ncibeneficiaire INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commission ADD CONSTRAINT FK_1C65015844AC3583 FOREIGN KEY (operation_id) REFERENCES operation (id)');
        $this->addSql('ALTER TABLE codeoperation ADD CONSTRAINT FK_CEC09B2644AC3583 FOREIGN KEY (operation_id) REFERENCES operation (id)');
        $this->addSql('ALTER TABLE codeoperation ADD CONSTRAINT FK_CEC09B2619EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE codeoperation DROP FOREIGN KEY FK_CEC09B2619EB6921');
        $this->addSql('DROP TABLE commission');
        $this->addSql('DROP TABLE codeoperation');
        $this->addSql('DROP TABLE client');
    }
}
