<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221219114511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE randonnee (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, duree_minutes INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session_rando (id INT AUTO_INCREMENT NOT NULL, la_randonnee_id INT NOT NULL, date DATETIME NOT NULL, nb_places INT NOT NULL, INDEX IDX_830258425C2CD9A8 (la_randonnee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE session_rando ADD CONSTRAINT FK_830258425C2CD9A8 FOREIGN KEY (la_randonnee_id) REFERENCES randonnee (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE session_rando DROP FOREIGN KEY FK_830258425C2CD9A8');
        $this->addSql('DROP TABLE randonnee');
        $this->addSql('DROP TABLE session_rando');
    }
}
