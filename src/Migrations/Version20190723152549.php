<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190723152549 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE typeoperation (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operation (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, libelle_id INT NOT NULL, date DATETIME NOT NULL, montant INT NOT NULL, frais INT NOT NULL, INDEX IDX_1981A66DFB88E14F (utilisateur_id), INDEX IDX_1981A66D25DD318D (libelle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66D25DD318D FOREIGN KEY (libelle_id) REFERENCES typeoperation (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66D25DD318D');
        $this->addSql('DROP TABLE typeoperation');
        $this->addSql('DROP TABLE operation');
    }
}
