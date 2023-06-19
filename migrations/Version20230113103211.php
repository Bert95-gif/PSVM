<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230113103211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE videojuego (id INT AUTO_INCREMENT NOT NULL, titulo VARCHAR(255) NOT NULL, calificacion INT NOT NULL, anio INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE videojuego_genero (videojuego_id INT NOT NULL, genero_id INT NOT NULL, INDEX IDX_88A29E6182925A85 (videojuego_id), INDEX IDX_88A29E61BCE7B795 (genero_id), PRIMARY KEY(videojuego_id, genero_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE videojuego_videoconsola (videojuego_id INT NOT NULL, videoconsola_id INT NOT NULL, INDEX IDX_A8DF102182925A85 (videojuego_id), INDEX IDX_A8DF102172789640 (videoconsola_id), PRIMARY KEY(videojuego_id, videoconsola_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE videojuego_genero ADD CONSTRAINT FK_88A29E6182925A85 FOREIGN KEY (videojuego_id) REFERENCES videojuego (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE videojuego_genero ADD CONSTRAINT FK_88A29E61BCE7B795 FOREIGN KEY (genero_id) REFERENCES genero (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE videojuego_videoconsola ADD CONSTRAINT FK_A8DF102182925A85 FOREIGN KEY (videojuego_id) REFERENCES videojuego (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE videojuego_videoconsola ADD CONSTRAINT FK_A8DF102172789640 FOREIGN KEY (videoconsola_id) REFERENCES videoconsola (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE videojuego_genero DROP FOREIGN KEY FK_88A29E6182925A85');
        $this->addSql('ALTER TABLE videojuego_genero DROP FOREIGN KEY FK_88A29E61BCE7B795');
        $this->addSql('ALTER TABLE videojuego_videoconsola DROP FOREIGN KEY FK_A8DF102182925A85');
        $this->addSql('ALTER TABLE videojuego_videoconsola DROP FOREIGN KEY FK_A8DF102172789640');
        $this->addSql('DROP TABLE videojuego');
        $this->addSql('DROP TABLE videojuego_genero');
        $this->addSql('DROP TABLE videojuego_videoconsola');
    }
}
