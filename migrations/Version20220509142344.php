<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220509142344 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresse (id INT AUTO_INCREMENT NOT NULL, zip_code INT DEFAULT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, rue INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bed (id INT AUTO_INCREMENT NOT NULL, place VARCHAR(255) NOT NULL, type VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, houssing_id INT DEFAULT NULL, begin_date DATETIME NOT NULL, end_date DATETIME NOT NULL, total_price INT NOT NULL, INDEX IDX_E00CEDDEA76ED395 (user_id), INDEX IDX_E00CEDDED21F0715 (houssing_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE houssing (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, adresse_id INT DEFAULT NULL, houssing_type_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, price DOUBLE PRECISION NOT NULL, status TINYINT(1) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, INDEX IDX_E86B1309A76ED395 (user_id), INDEX IDX_E86B13094DE7DC5C (adresse_id), INDEX IDX_E86B130982EA8311 (houssing_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE houssing_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, houssing_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_C53D045FD21F0715 (houssing_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `option` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE option_houssing (option_id INT NOT NULL, houssing_id INT NOT NULL, INDEX IDX_C81C62ADA7C41D6F (option_id), INDEX IDX_C81C62ADD21F0715 (houssing_id), PRIMARY KEY(option_id, houssing_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) DEFAULT NULL, surface VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room_detail (id INT AUTO_INCREMENT NOT NULL, room_id INT DEFAULT NULL, bed_id INT DEFAULT NULL, quantity INT NOT NULL, INDEX IDX_6F48B95254177093 (room_id), INDEX IDX_6F48B95288688BB9 (bed_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDED21F0715 FOREIGN KEY (houssing_id) REFERENCES houssing (id)');
        $this->addSql('ALTER TABLE houssing ADD CONSTRAINT FK_E86B1309A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE houssing ADD CONSTRAINT FK_E86B13094DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE houssing ADD CONSTRAINT FK_E86B130982EA8311 FOREIGN KEY (houssing_type_id) REFERENCES houssing_type (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FD21F0715 FOREIGN KEY (houssing_id) REFERENCES houssing (id)');
        $this->addSql('ALTER TABLE option_houssing ADD CONSTRAINT FK_C81C62ADA7C41D6F FOREIGN KEY (option_id) REFERENCES `option` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE option_houssing ADD CONSTRAINT FK_C81C62ADD21F0715 FOREIGN KEY (houssing_id) REFERENCES houssing (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE room_detail ADD CONSTRAINT FK_6F48B95254177093 FOREIGN KEY (room_id) REFERENCES room (id)');
        $this->addSql('ALTER TABLE room_detail ADD CONSTRAINT FK_6F48B95288688BB9 FOREIGN KEY (bed_id) REFERENCES bed (id)');
        $this->addSql('ALTER TABLE user ADD brith_date DATETIME NOT NULL, ADD full_name VARCHAR(255) NOT NULL, ADD is_verified TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE houssing DROP FOREIGN KEY FK_E86B13094DE7DC5C');
        $this->addSql('ALTER TABLE room_detail DROP FOREIGN KEY FK_6F48B95288688BB9');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDED21F0715');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FD21F0715');
        $this->addSql('ALTER TABLE option_houssing DROP FOREIGN KEY FK_C81C62ADD21F0715');
        $this->addSql('ALTER TABLE houssing DROP FOREIGN KEY FK_E86B130982EA8311');
        $this->addSql('ALTER TABLE option_houssing DROP FOREIGN KEY FK_C81C62ADA7C41D6F');
        $this->addSql('ALTER TABLE room_detail DROP FOREIGN KEY FK_6F48B95254177093');
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP TABLE bed');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE houssing');
        $this->addSql('DROP TABLE houssing_type');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE `option`');
        $this->addSql('DROP TABLE option_houssing');
        $this->addSql('DROP TABLE room');
        $this->addSql('DROP TABLE room_detail');
        $this->addSql('ALTER TABLE user DROP brith_date, DROP full_name, DROP is_verified');
    }
}
