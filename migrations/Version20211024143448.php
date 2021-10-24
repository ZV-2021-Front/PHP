<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211024143448 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE exchange_table_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE exchange_table_price_seq CASCADE');
        $this->addSql('DROP SEQUENCE apples2_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE aplles_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE apple_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE apple (id INT NOT NULL, products TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE apples DROP products');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE apple_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE exchange_table_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE exchange_table_price_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE apples2_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE aplles_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP TABLE apple');
        $this->addSql('ALTER TABLE apples ADD products TEXT DEFAULT NULL');
    }
}
