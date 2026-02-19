<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260219093737 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bike_document (id INT AUTO_INCREMENT NOT NULL, document_type VARCHAR(50) NOT NULL, document_name VARCHAR(255) NOT NULL, file_url VARCHAR(255) NOT NULL, upload_date DATE NOT NULL, expiry_date DATE NOT NULL, amount NUMERIC(10, 2) NOT NULL, notes LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, bike_id INT NOT NULL, INDEX IDX_80BB7AFED5A4816F (bike_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE bike_document ADD CONSTRAINT FK_80BB7AFED5A4816F FOREIGN KEY (bike_id) REFERENCES bike (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bike_document DROP FOREIGN KEY FK_80BB7AFED5A4816F');
        $this->addSql('DROP TABLE bike_document');
    }
}
