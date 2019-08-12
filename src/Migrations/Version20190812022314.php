<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190812022314 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE envoi ADD paysenvoi_id INT DEFAULT NULL, ADD pays_id INT DEFAULT NULL, ADD datedelivrance DATE DEFAULT NULL, ADD datedevalidite DATE DEFAULT NULL, ADD nom_b VARCHAR(255) NOT NULL, ADD prenom_b VARCHAR(255) NOT NULL, ADD telephone_b BIGINT NOT NULL, ADD adresse_b VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE envoi ADD CONSTRAINT FK_CA7E356657026CAD FOREIGN KEY (paysenvoi_id) REFERENCES pays (id)');
        $this->addSql('ALTER TABLE envoi ADD CONSTRAINT FK_CA7E3566A6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id)');
        $this->addSql('CREATE INDEX IDX_CA7E356657026CAD ON envoi (paysenvoi_id)');
        $this->addSql('CREATE INDEX IDX_CA7E3566A6E44244 ON envoi (pays_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE envoi DROP FOREIGN KEY FK_CA7E356657026CAD');
        $this->addSql('ALTER TABLE envoi DROP FOREIGN KEY FK_CA7E3566A6E44244');
        $this->addSql('DROP INDEX IDX_CA7E356657026CAD ON envoi');
        $this->addSql('DROP INDEX IDX_CA7E3566A6E44244 ON envoi');
        $this->addSql('ALTER TABLE envoi DROP paysenvoi_id, DROP pays_id, DROP datedelivrance, DROP datedevalidite, DROP nom_b, DROP prenom_b, DROP telephone_b, DROP adresse_b');
    }
}
