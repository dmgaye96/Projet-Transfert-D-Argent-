<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190724110210 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B398DE13AC');
        $this->addSql('DROP INDEX IDX_1D1C63B398DE13AC ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur ADD roles JSON NOT NULL, ADD password VARCHAR(255) NOT NULL, DROP partenaire_id, DROP motdepasse, DROP profil, CHANGE login login VARCHAR(180) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3AA08CB10 ON utilisateur (login)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_1D1C63B3AA08CB10 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur ADD partenaire_id INT NOT NULL, ADD profil VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP roles, CHANGE login login VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE email email VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE password motdepasse VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B398DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B398DE13AC ON utilisateur (partenaire_id)');
    }
}
