<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230201111520 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE concurso_videojuegos (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE concurso_videojuegos_videojuego (concurso_videojuegos_id INT NOT NULL, videojuego_id INT NOT NULL, INDEX IDX_95A7D9D3D69CD26E (concurso_videojuegos_id), INDEX IDX_95A7D9D382925A85 (videojuego_id), PRIMARY KEY(concurso_videojuegos_id, videojuego_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE concurso_videojuegos_videojuego ADD CONSTRAINT FK_95A7D9D3D69CD26E FOREIGN KEY (concurso_videojuegos_id) REFERENCES concurso_videojuegos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE concurso_videojuegos_videojuego ADD CONSTRAINT FK_95A7D9D382925A85 FOREIGN KEY (videojuego_id) REFERENCES videojuego (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE concurso_videojuegos_videojuego DROP FOREIGN KEY FK_95A7D9D3D69CD26E');
        $this->addSql('ALTER TABLE concurso_videojuegos_videojuego DROP FOREIGN KEY FK_95A7D9D382925A85');
        $this->addSql('DROP TABLE concurso_videojuegos');
        $this->addSql('DROP TABLE concurso_videojuegos_videojuego');
    }
}
