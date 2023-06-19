<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230307060629 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE concurso_series ADD serie_ganadora_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE concurso_series ADD CONSTRAINT FK_1663A077BC427FCB FOREIGN KEY (serie_ganadora_id) REFERENCES serie (id)');
        $this->addSql('CREATE INDEX IDX_1663A077BC427FCB ON concurso_series (serie_ganadora_id)');
        $this->addSql('ALTER TABLE serie DROP FOREIGN KEY FK_AA3A9334F415D168');
        $this->addSql('DROP INDEX IDX_AA3A9334F415D168 ON serie');
        $this->addSql('ALTER TABLE serie DROP concurso_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE concurso_series DROP FOREIGN KEY FK_1663A077BC427FCB');
        $this->addSql('DROP INDEX IDX_1663A077BC427FCB ON concurso_series');
        $this->addSql('ALTER TABLE concurso_series DROP serie_ganadora_id');
        $this->addSql('ALTER TABLE serie ADD concurso_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE serie ADD CONSTRAINT FK_AA3A9334F415D168 FOREIGN KEY (concurso_id) REFERENCES concurso_series (id)');
        $this->addSql('CREATE INDEX IDX_AA3A9334F415D168 ON serie (concurso_id)');
    }
}
