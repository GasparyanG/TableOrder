<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190205114234 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, table_id_id INT NOT NULL, restauran_id_id INT NOT NULL, user_id INT NOT NULL, reservation_date DATE NOT NULL, reservation_time TIME NOT NULL, amount_of_time INT NOT NULL, INDEX IDX_42C8495573B8532F (table_id_id), INDEX IDX_42C849558D1C8BDD (restauran_id_id), INDEX IDX_42C84955A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495573B8532F FOREIGN KEY (table_id_id) REFERENCES restaurant_table (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849558D1C8BDD FOREIGN KEY (restauran_id_id) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE restaurant_owner');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE restaurant_owner (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, last_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, cookie_id VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, username VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, password VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, registration_date INT NOT NULL, roles JSON NOT NULL, UNIQUE INDEX UNIQ_857D55ADF85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE reservation');
    }
}
