<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230105045913 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE serie_genero (serie_id INT NOT NULL, genero_id INT NOT NULL, INDEX IDX_57AAD353D94388BD (serie_id), INDEX IDX_57AAD353BCE7B795 (genero_id), PRIMARY KEY(serie_id, genero_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE serie_genero ADD CONSTRAINT FK_57AAD353D94388BD FOREIGN KEY (serie_id) REFERENCES serie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE serie_genero ADD CONSTRAINT FK_57AAD353BCE7B795 FOREIGN KEY (genero_id) REFERENCES genero (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE serie_genero DROP FOREIGN KEY FK_57AAD353D94388BD');
        $this->addSql('ALTER TABLE serie_genero DROP FOREIGN KEY FK_57AAD353BCE7B795');
        $this->addSql('DROP TABLE serie_genero');
    }
}
