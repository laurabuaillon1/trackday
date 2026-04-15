<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260409123829 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE document_legal (id INT AUTO_INCREMENT NOT NULL, version NUMERIC(10, 2) NOT NULL, text_content LONGTEXT NOT NULL, publication_date DATE NOT NULL, is_active TINYINT NOT NULL, document_type_id INT NOT NULL, INDEX IDX_8AC3B62261232A4F (document_type_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE document_type (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(50) NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE document_legal ADD CONSTRAINT FK_8AC3B62261232A4F FOREIGN KEY (document_type_id) REFERENCES document_type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document_legal DROP FOREIGN KEY FK_8AC3B62261232A4F');
        $this->addSql('DROP TABLE document_legal');
        $this->addSql('DROP TABLE document_type');
    }
}
