<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190816011612 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE retrait ADD envoi_id INT NOT NULL');
        $this->addSql('ALTER TABLE retrait ADD CONSTRAINT FK_D9846A513F97ECE5 FOREIGN KEY (envoi_id) REFERENCES envoi (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D9846A513F97ECE5 ON retrait (envoi_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE retrait DROP FOREIGN KEY FK_D9846A513F97ECE5');
        $this->addSql('DROP INDEX UNIQ_D9846A513F97ECE5 ON retrait');
        $this->addSql('ALTER TABLE retrait DROP envoi_id');
    }
}
