<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190205114507 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495573B8532F');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849558D1C8BDD');
        $this->addSql('DROP INDEX IDX_42C8495573B8532F ON reservation');
        $this->addSql('DROP INDEX IDX_42C849558D1C8BDD ON reservation');
        $this->addSql('ALTER TABLE reservation ADD table_id INT NOT NULL, ADD restauran_id INT NOT NULL, DROP table_id_id, DROP restauran_id_id');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955ECFF285C FOREIGN KEY (table_id) REFERENCES restaurant_table (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495520467EB0 FOREIGN KEY (restauran_id) REFERENCES restaurant (id)');
        $this->addSql('CREATE INDEX IDX_42C84955ECFF285C ON reservation (table_id)');
        $this->addSql('CREATE INDEX IDX_42C8495520467EB0 ON reservation (restauran_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955ECFF285C');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495520467EB0');
        $this->addSql('DROP INDEX IDX_42C84955ECFF285C ON reservation');
        $this->addSql('DROP INDEX IDX_42C8495520467EB0 ON reservation');
        $this->addSql('ALTER TABLE reservation ADD table_id_id INT NOT NULL, ADD restauran_id_id INT NOT NULL, DROP table_id, DROP restauran_id');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495573B8532F FOREIGN KEY (table_id_id) REFERENCES restaurant_table (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849558D1C8BDD FOREIGN KEY (restauran_id_id) REFERENCES restaurant (id)');
        $this->addSql('CREATE INDEX IDX_42C8495573B8532F ON reservation (table_id_id)');
        $this->addSql('CREATE INDEX IDX_42C849558D1C8BDD ON reservation (restauran_id_id)');
    }
}
