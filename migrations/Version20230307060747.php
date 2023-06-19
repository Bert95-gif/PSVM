<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230307060747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE concurso_canciones ADD cancion_ganadora_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE concurso_canciones ADD CONSTRAINT FK_B1DCEEE5BC05BB12 FOREIGN KEY (cancion_ganadora_id) REFERENCES cancion (id)');
        $this->addSql('CREATE INDEX IDX_B1DCEEE5BC05BB12 ON concurso_canciones (cancion_ganadora_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE concurso_canciones DROP FOREIGN KEY FK_B1DCEEE5BC05BB12');
        $this->addSql('DROP INDEX IDX_B1DCEEE5BC05BB12 ON concurso_canciones');
        $this->addSql('ALTER TABLE concurso_canciones DROP cancion_ganadora_id');
    }
}
