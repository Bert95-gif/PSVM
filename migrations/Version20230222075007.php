<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230222075007 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE franquicia (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE franquicia_pelicula (franquicia_id INT NOT NULL, pelicula_id INT NOT NULL, INDEX IDX_A46C14602AF98489 (franquicia_id), INDEX IDX_A46C146070713909 (pelicula_id), PRIMARY KEY(franquicia_id, pelicula_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE franquicia_serie (franquicia_id INT NOT NULL, serie_id INT NOT NULL, INDEX IDX_C655FF812AF98489 (franquicia_id), INDEX IDX_C655FF81D94388BD (serie_id), PRIMARY KEY(franquicia_id, serie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE franquicia_videojuego (franquicia_id INT NOT NULL, videojuego_id INT NOT NULL, INDEX IDX_894A0A932AF98489 (franquicia_id), INDEX IDX_894A0A9382925A85 (videojuego_id), PRIMARY KEY(franquicia_id, videojuego_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE franquicia_pelicula ADD CONSTRAINT FK_A46C14602AF98489 FOREIGN KEY (franquicia_id) REFERENCES franquicia (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE franquicia_pelicula ADD CONSTRAINT FK_A46C146070713909 FOREIGN KEY (pelicula_id) REFERENCES pelicula (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE franquicia_serie ADD CONSTRAINT FK_C655FF812AF98489 FOREIGN KEY (franquicia_id) REFERENCES franquicia (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE franquicia_serie ADD CONSTRAINT FK_C655FF81D94388BD FOREIGN KEY (serie_id) REFERENCES serie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE franquicia_videojuego ADD CONSTRAINT FK_894A0A932AF98489 FOREIGN KEY (franquicia_id) REFERENCES franquicia (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE franquicia_videojuego ADD CONSTRAINT FK_894A0A9382925A85 FOREIGN KEY (videojuego_id) REFERENCES videojuego (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE franquicia_pelicula DROP FOREIGN KEY FK_A46C14602AF98489');
        $this->addSql('ALTER TABLE franquicia_pelicula DROP FOREIGN KEY FK_A46C146070713909');
        $this->addSql('ALTER TABLE franquicia_serie DROP FOREIGN KEY FK_C655FF812AF98489');
        $this->addSql('ALTER TABLE franquicia_serie DROP FOREIGN KEY FK_C655FF81D94388BD');
        $this->addSql('ALTER TABLE franquicia_videojuego DROP FOREIGN KEY FK_894A0A932AF98489');
        $this->addSql('ALTER TABLE franquicia_videojuego DROP FOREIGN KEY FK_894A0A9382925A85');
        $this->addSql('DROP TABLE franquicia');
        $this->addSql('DROP TABLE franquicia_pelicula');
        $this->addSql('DROP TABLE franquicia_serie');
        $this->addSql('DROP TABLE franquicia_videojuego');
    }
}
