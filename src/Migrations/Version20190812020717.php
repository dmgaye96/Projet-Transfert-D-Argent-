<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190812020717 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE envoi ADD piece_id INT NOT NULL, ADD numeropiece BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE envoi ADD CONSTRAINT FK_CA7E3566C40FCFA8 FOREIGN KEY (piece_id) REFERENCES typedepiece (id)');
        $this->addSql('CREATE INDEX IDX_CA7E3566C40FCFA8 ON envoi (piece_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE envoi DROP FOREIGN KEY FK_CA7E3566C40FCFA8');
        $this->addSql('DROP INDEX IDX_CA7E3566C40FCFA8 ON envoi');
        $this->addSql('ALTER TABLE envoi DROP piece_id, DROP numeropiece');
    }
}
