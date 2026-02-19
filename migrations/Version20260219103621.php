<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260219103621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bike_maintenance (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, mileage INT NOT NULL, hours INT NOT NULL, maintenance_type VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, cost NUMERIC(10, 2) DEFAULT NULL, workshop VARCHAR(255) DEFAULT NULL, parts_used VARCHAR(255) DEFAULT NULL, next_service_date DATE DEFAULT NULL, next_service_km INT DEFAULT NULL, next_service_hours INT DEFAULT NULL, receipt_url VARCHAR(255) DEFAULT NULL, notes LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, bike_id INT NOT NULL, INDEX IDX_BCC3E0CCD5A4816F (bike_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE bike_maintenance ADD CONSTRAINT FK_BCC3E0CCD5A4816F FOREIGN KEY (bike_id) REFERENCES bike (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bike_maintenance DROP FOREIGN KEY FK_BCC3E0CCD5A4816F');
        $this->addSql('DROP TABLE bike_maintenance');
    }
}
