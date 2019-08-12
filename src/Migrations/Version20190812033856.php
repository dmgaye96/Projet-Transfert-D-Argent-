<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190812033856 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE envoi ADD commitionttc_id INT DEFAULT NULL, ADD guichetier_id INT DEFAULT NULL, ADD codeenvoi VARCHAR(255) NOT NULL, ADD numero VARCHAR(255) DEFAULT NULL, ADD total NUMERIC(10, 0) NOT NULL, ADD commissionetat NUMERIC(10, 0) DEFAULT NULL, ADD commissionsysteme NUMERIC(10, 0) DEFAULT NULL, ADD commissionguichetenvoie NUMERIC(10, 0) DEFAULT NULL, ADD commissionguicheretrait NUMERIC(10, 0) DEFAULT NULL');
        $this->addSql('ALTER TABLE envoi ADD CONSTRAINT FK_CA7E35667B30B27C FOREIGN KEY (commitionttc_id) REFERENCES commissions (id)');
        $this->addSql('ALTER TABLE envoi ADD CONSTRAINT FK_CA7E356690DCD06F FOREIGN KEY (guichetier_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_CA7E35667B30B27C ON envoi (commitionttc_id)');
        $this->addSql('CREATE INDEX IDX_CA7E356690DCD06F ON envoi (guichetier_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE envoi DROP FOREIGN KEY FK_CA7E35667B30B27C');
        $this->addSql('ALTER TABLE envoi DROP FOREIGN KEY FK_CA7E356690DCD06F');
        $this->addSql('DROP INDEX IDX_CA7E35667B30B27C ON envoi');
        $this->addSql('DROP INDEX IDX_CA7E356690DCD06F ON envoi');
        $this->addSql('ALTER TABLE envoi DROP commitionttc_id, DROP guichetier_id, DROP codeenvoi, DROP numero, DROP total, DROP commissionetat, DROP commissionsysteme, DROP commissionguichetenvoie, DROP commissionguicheretrait');
    }
}
