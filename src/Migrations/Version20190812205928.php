<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190812205928 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE envoi DROP FOREIGN KEY FK_CA7E35667B30B27C');
        $this->addSql('DROP INDEX IDX_CA7E35667B30B27C ON envoi');
        $this->addSql('ALTER TABLE envoi ADD commitionttc BIGINT DEFAULT NULL, DROP commitionttc_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE envoi ADD commitionttc_id INT DEFAULT NULL, DROP commitionttc');
        $this->addSql('ALTER TABLE envoi ADD CONSTRAINT FK_CA7E35667B30B27C FOREIGN KEY (commitionttc_id) REFERENCES commissions (id)');
        $this->addSql('CREATE INDEX IDX_CA7E35667B30B27C ON envoi (commitionttc_id)');
    }
}
