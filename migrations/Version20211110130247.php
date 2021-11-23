<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211110130247 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE apple_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE russian_aliases_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE apples ALTER date TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE apples ALTER date DROP DEFAULT');
        $this->addSql('ALTER TABLE apples ALTER "time" TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE apples ALTER "time" DROP DEFAULT');
        $this->addSql('ALTER TABLE russian_aliases ALTER field SET NOT NULL');
        $this->addSql('ALTER TABLE russian_aliases ALTER russian_aliases TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE russian_aliases ALTER russian_aliases DROP DEFAULT');
        $this->addSql('ALTER TABLE russian_aliases ALTER russian_aliases SET NOT NULL');
        $this->addSql('ALTER TABLE russian_aliases ALTER data_base TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE russian_aliases ALTER data_base DROP DEFAULT');
        $this->addSql('ALTER TABLE russian_aliases ALTER data_base SET NOT NULL');
        $this->addSql('ALTER TABLE russian_aliases ALTER table_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE russian_aliases ALTER table_name DROP DEFAULT');
        $this->addSql('ALTER TABLE russian_aliases ALTER table_name SET NOT NULL');
        $this->addSql('COMMENT ON COLUMN russian_aliases.field IS NULL');
        $this->addSql('COMMENT ON COLUMN russian_aliases.russian_aliases IS NULL');
        $this->addSql('COMMENT ON COLUMN russian_aliases.data_base IS NULL');
        $this->addSql('COMMENT ON COLUMN russian_aliases.table_name IS NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE russian_aliases_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE apple_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE apples ALTER date TYPE DATE');
        $this->addSql('ALTER TABLE apples ALTER date DROP DEFAULT');
        $this->addSql('ALTER TABLE apples ALTER time TYPE TIME(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE apples ALTER time DROP DEFAULT');
        $this->addSql('ALTER TABLE russian_aliases ALTER field DROP NOT NULL');
        $this->addSql('ALTER TABLE russian_aliases ALTER russian_aliases TYPE TEXT');
        $this->addSql('ALTER TABLE russian_aliases ALTER russian_aliases DROP DEFAULT');
        $this->addSql('ALTER TABLE russian_aliases ALTER russian_aliases DROP NOT NULL');
        $this->addSql('ALTER TABLE russian_aliases ALTER data_base TYPE TEXT');
        $this->addSql('ALTER TABLE russian_aliases ALTER data_base DROP DEFAULT');
        $this->addSql('ALTER TABLE russian_aliases ALTER data_base DROP NOT NULL');
        $this->addSql('ALTER TABLE russian_aliases ALTER table_name TYPE TEXT');
        $this->addSql('ALTER TABLE russian_aliases ALTER table_name DROP DEFAULT');
        $this->addSql('ALTER TABLE russian_aliases ALTER table_name DROP NOT NULL');
        $this->addSql('COMMENT ON COLUMN russian_aliases.field IS \'имя поля\'');
        $this->addSql('COMMENT ON COLUMN russian_aliases.russian_aliases IS \'название на русском\'');
        $this->addSql('COMMENT ON COLUMN russian_aliases.data_base IS \'имя базы данных\'');
        $this->addSql('COMMENT ON COLUMN russian_aliases.table_name IS \'имя таблицы\'');
    }
}
