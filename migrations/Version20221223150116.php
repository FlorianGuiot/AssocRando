<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221223150116 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE utilisateur_session_rando (utilisateur_id INT NOT NULL, session_rando_id INT NOT NULL, INDEX IDX_A7DF09C0FB88E14F (utilisateur_id), INDEX IDX_A7DF09C089332A6D (session_rando_id), PRIMARY KEY(utilisateur_id, session_rando_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE utilisateur_session_rando ADD CONSTRAINT FK_A7DF09C0FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur_session_rando ADD CONSTRAINT FK_A7DF09C089332A6D FOREIGN KEY (session_rando_id) REFERENCES session_rando (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur ADD nom VARCHAR(50) NOT NULL, ADD prenom VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur_session_rando DROP FOREIGN KEY FK_A7DF09C0FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_session_rando DROP FOREIGN KEY FK_A7DF09C089332A6D');
        $this->addSql('DROP TABLE utilisateur_session_rando');
        $this->addSql('ALTER TABLE utilisateur DROP nom, DROP prenom');
    }
}
