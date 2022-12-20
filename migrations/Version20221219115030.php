<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221219115030 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, la_randonnee_id INT NOT NULL, lien VARCHAR(255) NOT NULL, INDEX IDX_C53D045F5C2CD9A8 (la_randonnee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F5C2CD9A8 FOREIGN KEY (la_randonnee_id) REFERENCES randonnee (id)');
        $this->addSql('ALTER TABLE randonnee ADD la_miniature_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE randonnee ADD CONSTRAINT FK_CB71A99F4D9C54F FOREIGN KEY (la_miniature_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CB71A99F4D9C54F ON randonnee (la_miniature_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE randonnee DROP FOREIGN KEY FK_CB71A99F4D9C54F');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F5C2CD9A8');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP INDEX UNIQ_CB71A99F4D9C54F ON randonnee');
        $this->addSql('ALTER TABLE randonnee DROP la_miniature_id');
    }
}
