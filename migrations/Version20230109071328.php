<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230109071328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE concurso_series (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE concurso_series_serie (concurso_series_id INT NOT NULL, serie_id INT NOT NULL, INDEX IDX_773A5A684D4337F8 (concurso_series_id), INDEX IDX_773A5A68D94388BD (serie_id), PRIMARY KEY(concurso_series_id, serie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE concurso_series_serie ADD CONSTRAINT FK_773A5A684D4337F8 FOREIGN KEY (concurso_series_id) REFERENCES concurso_series (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE concurso_series_serie ADD CONSTRAINT FK_773A5A68D94388BD FOREIGN KEY (serie_id) REFERENCES serie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE serie ADD concurso_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE serie ADD CONSTRAINT FK_AA3A9334F415D168 FOREIGN KEY (concurso_id) REFERENCES concurso_series (id)');
        $this->addSql('CREATE INDEX IDX_AA3A9334F415D168 ON serie (concurso_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE serie DROP FOREIGN KEY FK_AA3A9334F415D168');
        $this->addSql('ALTER TABLE concurso_series_serie DROP FOREIGN KEY FK_773A5A684D4337F8');
        $this->addSql('ALTER TABLE concurso_series_serie DROP FOREIGN KEY FK_773A5A68D94388BD');
        $this->addSql('DROP TABLE concurso_series');
        $this->addSql('DROP TABLE concurso_series_serie');
        $this->addSql('DROP INDEX IDX_AA3A9334F415D168 ON serie');
        $this->addSql('ALTER TABLE serie DROP concurso_id');
    }
}
