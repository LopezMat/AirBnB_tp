<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240123152139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE equipement (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, logement_id_id INT DEFAULT NULL, image_path VARCHAR(255) NOT NULL, alt LONGTEXT NOT NULL, INDEX IDX_E01FBE6A884C09A7 (logement_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE logement (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, prix INT NOT NULL, taille DOUBLE PRECISION NOT NULL, description LONGTEXT NOT NULL, couchage INT NOT NULL, is_active TINYINT(1) NOT NULL, adresse VARCHAR(255) NOT NULL, code_postal INT NOT NULL, ville VARCHAR(255) NOT NULL, pays VARCHAR(255) NOT NULL, image_path VARCHAR(255) NOT NULL, INDEX IDX_F0FD44579D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE logement_equipement (logement_id INT NOT NULL, equipement_id INT NOT NULL, INDEX IDX_85F9697158ABF955 (logement_id), INDEX IDX_85F96971806F0F5C (equipement_id), PRIMARY KEY(logement_id, equipement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE logement_type (logement_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_E61EFABD58ABF955 (logement_id), INDEX IDX_E61EFABDC54C8C93 (type_id), PRIMARY KEY(logement_id, type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, id_logement_id INT DEFAULT NULL, id_user_id INT NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, UNIQUE INDEX UNIQ_42C8495540B934A2 (id_logement_id), INDEX IDX_42C8495579F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, image_path VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A884C09A7 FOREIGN KEY (logement_id_id) REFERENCES logement (id)');
        $this->addSql('ALTER TABLE logement ADD CONSTRAINT FK_F0FD44579D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE logement_equipement ADD CONSTRAINT FK_85F9697158ABF955 FOREIGN KEY (logement_id) REFERENCES logement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE logement_equipement ADD CONSTRAINT FK_85F96971806F0F5C FOREIGN KEY (equipement_id) REFERENCES equipement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE logement_type ADD CONSTRAINT FK_E61EFABD58ABF955 FOREIGN KEY (logement_id) REFERENCES logement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE logement_type ADD CONSTRAINT FK_E61EFABDC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495540B934A2 FOREIGN KEY (id_logement_id) REFERENCES logement (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495579F37AE5 FOREIGN KEY (id_user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A884C09A7');
        $this->addSql('ALTER TABLE logement DROP FOREIGN KEY FK_F0FD44579D86650F');
        $this->addSql('ALTER TABLE logement_equipement DROP FOREIGN KEY FK_85F9697158ABF955');
        $this->addSql('ALTER TABLE logement_equipement DROP FOREIGN KEY FK_85F96971806F0F5C');
        $this->addSql('ALTER TABLE logement_type DROP FOREIGN KEY FK_E61EFABD58ABF955');
        $this->addSql('ALTER TABLE logement_type DROP FOREIGN KEY FK_E61EFABDC54C8C93');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495540B934A2');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495579F37AE5');
        $this->addSql('DROP TABLE equipement');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE logement');
        $this->addSql('DROP TABLE logement_equipement');
        $this->addSql('DROP TABLE logement_type');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE `user`');
    }
}
