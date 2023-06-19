<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230105045320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE concurso_peliculas (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE concurso_peliculas_pelicula (concurso_peliculas_id INT NOT NULL, pelicula_id INT NOT NULL, INDEX IDX_517D6659365259F9 (concurso_peliculas_id), INDEX IDX_517D665970713909 (pelicula_id), PRIMARY KEY(concurso_peliculas_id, pelicula_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE concurso_peliculas_pelicula ADD CONSTRAINT FK_517D6659365259F9 FOREIGN KEY (concurso_peliculas_id) REFERENCES concurso_peliculas (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE concurso_peliculas_pelicula ADD CONSTRAINT FK_517D665970713909 FOREIGN KEY (pelicula_id) REFERENCES pelicula (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pelicula ADD concurso_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pelicula ADD CONSTRAINT FK_73BC7095F415D168 FOREIGN KEY (concurso_id) REFERENCES concurso_peliculas (id)');
        $this->addSql('CREATE INDEX IDX_73BC7095F415D168 ON pelicula (concurso_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pelicula DROP FOREIGN KEY FK_73BC7095F415D168');
        $this->addSql('ALTER TABLE concurso_peliculas_pelicula DROP FOREIGN KEY FK_517D6659365259F9');
        $this->addSql('ALTER TABLE concurso_peliculas_pelicula DROP FOREIGN KEY FK_517D665970713909');
        $this->addSql('DROP TABLE concurso_peliculas');
        $this->addSql('DROP TABLE concurso_peliculas_pelicula');
        $this->addSql('DROP INDEX IDX_73BC7095F415D168 ON pelicula');
        $this->addSql('ALTER TABLE pelicula DROP concurso_id');
    }
}
