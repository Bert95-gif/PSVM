<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230303110639 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE concurso_canciones (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE concurso_canciones_cancion (concurso_canciones_id INT NOT NULL, cancion_id INT NOT NULL, INDEX IDX_40DEE56286F09757 (concurso_canciones_id), INDEX IDX_40DEE5629B1D840F (cancion_id), PRIMARY KEY(concurso_canciones_id, cancion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE concurso_canciones_cancion ADD CONSTRAINT FK_40DEE56286F09757 FOREIGN KEY (concurso_canciones_id) REFERENCES concurso_canciones (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE concurso_canciones_cancion ADD CONSTRAINT FK_40DEE5629B1D840F FOREIGN KEY (cancion_id) REFERENCES cancion (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE concurso_canciones_cancion DROP FOREIGN KEY FK_40DEE56286F09757');
        $this->addSql('ALTER TABLE concurso_canciones_cancion DROP FOREIGN KEY FK_40DEE5629B1D840F');
        $this->addSql('DROP TABLE concurso_canciones');
        $this->addSql('DROP TABLE concurso_canciones_cancion');
    }
}
