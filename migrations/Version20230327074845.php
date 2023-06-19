<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230327074845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE voto_videojuego (id INT AUTO_INCREMENT NOT NULL, concurso_id INT DEFAULT NULL, videojuego_id INT DEFAULT NULL, INDEX IDX_AB25FF63F415D168 (concurso_id), INDEX IDX_AB25FF6382925A85 (videojuego_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE voto_videojuego ADD CONSTRAINT FK_AB25FF63F415D168 FOREIGN KEY (concurso_id) REFERENCES concurso_videojuegos (id)');
        $this->addSql('ALTER TABLE voto_videojuego ADD CONSTRAINT FK_AB25FF6382925A85 FOREIGN KEY (videojuego_id) REFERENCES videojuego (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voto_videojuego DROP FOREIGN KEY FK_AB25FF63F415D168');
        $this->addSql('ALTER TABLE voto_videojuego DROP FOREIGN KEY FK_AB25FF6382925A85');
        $this->addSql('DROP TABLE voto_videojuego');
    }
}
