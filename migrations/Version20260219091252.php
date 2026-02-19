<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260219091252 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bike (id INT AUTO_INCREMENT NOT NULL, nickname VARCHAR(255) DEFAULT NULL, brand VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, year SMALLINT DEFAULT NULL, displacement VARCHAR(255) DEFAULT NULL, color VARCHAR(255) DEFAULT NULL, license_plate VARCHAR(15) DEFAULT NULL, purchase_date DATE DEFAULT NULL, mileage INT DEFAULT NULL, hours INT DEFAULT NULL, usage_unit VARCHAR(10) NOT NULL, last_service_date DATE DEFAULT NULL, next_service_km INT DEFAULT NULL, next_service_hours INT DEFAULT NULL, photo_url VARCHAR(255) DEFAULT NULL, notes LONGTEXT DEFAULT NULL, is_active TINYINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, user_id INT NOT NULL, INDEX IDX_4CBC3780A76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE bike ADD CONSTRAINT FK_4CBC3780A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bike DROP FOREIGN KEY FK_4CBC3780A76ED395');
        $this->addSql('DROP TABLE bike');
    }
}
