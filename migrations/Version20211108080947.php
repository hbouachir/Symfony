<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211108080947 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, nom_id INT DEFAULT NULL, personne_id INT DEFAULT NULL, numero_compte VARCHAR(255) NOT NULL, civilite VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, date_expiration DATE NOT NULL, INDEX IDX_6D28840DC8121CE9 (nom_id), INDEX IDX_6D28840DA21BD112 (personne_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DC8121CE9 FOREIGN KEY (nom_id) REFERENCES personne (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DA21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DC8121CE9');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DA21BD112');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE personne');
    }
}
