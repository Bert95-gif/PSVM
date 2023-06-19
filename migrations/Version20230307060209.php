<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230307060209 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE concurso_peliculas DROP INDEX UNIQ_842312D4B279CC3E, ADD INDEX IDX_842312D4B279CC3E (pelicula_ganadora_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE concurso_peliculas DROP INDEX IDX_842312D4B279CC3E, ADD UNIQUE INDEX UNIQ_842312D4B279CC3E (pelicula_ganadora_id)');
    }
}
