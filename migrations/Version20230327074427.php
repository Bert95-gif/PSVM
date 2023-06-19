<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230327074427 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE voto_pelicula (id INT AUTO_INCREMENT NOT NULL, concurso_id INT DEFAULT NULL, pelicula_votada_id INT DEFAULT NULL, pelicula VARCHAR(255) NOT NULL, INDEX IDX_9AC14975F415D168 (concurso_id), INDEX IDX_9AC149757B841D3 (pelicula_votada_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE voto_pelicula ADD CONSTRAINT FK_9AC14975F415D168 FOREIGN KEY (concurso_id) REFERENCES concurso_peliculas (id)');
        $this->addSql('ALTER TABLE voto_pelicula ADD CONSTRAINT FK_9AC149757B841D3 FOREIGN KEY (pelicula_votada_id) REFERENCES pelicula (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voto_pelicula DROP FOREIGN KEY FK_9AC14975F415D168');
        $this->addSql('ALTER TABLE voto_pelicula DROP FOREIGN KEY FK_9AC149757B841D3');
        $this->addSql('DROP TABLE voto_pelicula');
    }
}
