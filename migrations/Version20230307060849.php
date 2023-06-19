<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230307060849 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE concurso_videojuegos ADD juego_ganador_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE concurso_videojuegos ADD CONSTRAINT FK_AE3E9EC99E5E59D3 FOREIGN KEY (juego_ganador_id) REFERENCES videojuego (id)');
        $this->addSql('CREATE INDEX IDX_AE3E9EC99E5E59D3 ON concurso_videojuegos (juego_ganador_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE concurso_videojuegos DROP FOREIGN KEY FK_AE3E9EC99E5E59D3');
        $this->addSql('DROP INDEX IDX_AE3E9EC99E5E59D3 ON concurso_videojuegos');
        $this->addSql('ALTER TABLE concurso_videojuegos DROP juego_ganador_id');
    }
}
