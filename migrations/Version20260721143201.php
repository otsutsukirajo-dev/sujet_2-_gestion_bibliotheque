<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260721143201 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE auteur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE emprunt (id INT AUTO_INCREMENT NOT NULL, date_emprunt DATETIME NOT NULL, date_retour_prevue DATETIME NOT NULL, date_retour_effective DATETIME DEFAULT NULL, livre_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_364071D737D925CB (livre_id), INDEX IDX_364071D7A76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE livre (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, est_disponible TINYINT NOT NULL, auteur_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_AC634F9960BB6FE6 (auteur_id), INDEX IDX_AC634F99BCF5E72D (categorie_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, is_verified TINYINT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D737D925CB FOREIGN KEY (livre_id) REFERENCES livre (id)');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F9960BB6FE6 FOREIGN KEY (auteur_id) REFERENCES auteur (id)');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F99BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D737D925CB');
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D7A76ED395');
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_AC634F9960BB6FE6');
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_AC634F99BCF5E72D');
        $this->addSql('DROP TABLE auteur');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE emprunt');
        $this->addSql('DROP TABLE livre');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
