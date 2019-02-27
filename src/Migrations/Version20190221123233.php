<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190221123233 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bookmark DROP FOREIGN KEY FK_DA62921DB1E7706E');
        $this->addSql('DROP INDEX IDX_DA62921DB1E7706E ON bookmark');
        $this->addSql('ALTER TABLE bookmark DROP restaurant_id, DROP bookmark_time');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bookmark ADD restaurant_id INT DEFAULT NULL, ADD bookmark_time TIME DEFAULT NULL');
        $this->addSql('ALTER TABLE bookmark ADD CONSTRAINT FK_DA62921DB1E7706E FOREIGN KEY (restaurant_id) REFERENCES reservation (id)');
        $this->addSql('CREATE INDEX IDX_DA62921DB1E7706E ON bookmark (restaurant_id)');
    }
}
