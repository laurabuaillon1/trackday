<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260407151534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bike_document CHANGE file_url file_url VARCHAR(255) DEFAULT NULL, CHANGE upload_date upload_date DATE DEFAULT NULL, CHANGE expiry_date expiry_date DATE DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bike_document CHANGE file_url file_url VARCHAR(255) NOT NULL, CHANGE upload_date upload_date DATE NOT NULL, CHANGE expiry_date expiry_date DATE NOT NULL');
    }
}
