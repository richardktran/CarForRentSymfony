<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220615152215 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, thumbnail_id INT NOT NULL, created_user_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, color VARCHAR(255) NOT NULL, brand VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, seats INT NOT NULL, year INT NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_773DE69DFDFF2E92 (thumbnail_id), INDEX IDX_773DE69DE104C1D3 (created_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DFDFF2E92 FOREIGN KEY (thumbnail_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DE104C1D3 FOREIGN KEY (created_user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DFDFF2E92');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DE104C1D3');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE user');
    }
}
