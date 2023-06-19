<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230306092118 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE concurso_peliculas ADD pelicula_ganadora_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE concurso_peliculas ADD CONSTRAINT FK_842312D4B279CC3E FOREIGN KEY (pelicula_ganadora_id) REFERENCES pelicula (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_842312D4B279CC3E ON concurso_peliculas (pelicula_ganadora_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE concurso_peliculas DROP FOREIGN KEY FK_842312D4B279CC3E');
        $this->addSql('DROP INDEX UNIQ_842312D4B279CC3E ON concurso_peliculas');
        $this->addSql('ALTER TABLE concurso_peliculas DROP pelicula_ganadora_id');
    }
}
