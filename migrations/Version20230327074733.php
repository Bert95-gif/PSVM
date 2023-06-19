<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230327074733 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE voto_serie (id INT AUTO_INCREMENT NOT NULL, concurso_id INT DEFAULT NULL, serie_votada_id INT DEFAULT NULL, INDEX IDX_5F23AEB1F415D168 (concurso_id), INDEX IDX_5F23AEB1E99657D9 (serie_votada_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE voto_serie ADD CONSTRAINT FK_5F23AEB1F415D168 FOREIGN KEY (concurso_id) REFERENCES concurso_series (id)');
        $this->addSql('ALTER TABLE voto_serie ADD CONSTRAINT FK_5F23AEB1E99657D9 FOREIGN KEY (serie_votada_id) REFERENCES serie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voto_serie DROP FOREIGN KEY FK_5F23AEB1F415D168');
        $this->addSql('ALTER TABLE voto_serie DROP FOREIGN KEY FK_5F23AEB1E99657D9');
        $this->addSql('DROP TABLE voto_serie');
    }
}
