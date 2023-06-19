<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230220061851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cancion_genero_musical (cancion_id INT NOT NULL, genero_musical_id INT NOT NULL, INDEX IDX_64C5AB469B1D840F (cancion_id), INDEX IDX_64C5AB467585C460 (genero_musical_id), PRIMARY KEY(cancion_id, genero_musical_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cancion_genero_musical ADD CONSTRAINT FK_64C5AB469B1D840F FOREIGN KEY (cancion_id) REFERENCES cancion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cancion_genero_musical ADD CONSTRAINT FK_64C5AB467585C460 FOREIGN KEY (genero_musical_id) REFERENCES genero_musical (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cancion_genero_musical DROP FOREIGN KEY FK_64C5AB469B1D840F');
        $this->addSql('ALTER TABLE cancion_genero_musical DROP FOREIGN KEY FK_64C5AB467585C460');
        $this->addSql('DROP TABLE cancion_genero_musical');
    }
}
