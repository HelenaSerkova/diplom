<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210305224408 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `admin` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_880E0D76E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, categories_id INT DEFAULT NULL, title VARCHAR(100) NOT NULL, text TEXT NOT NULL, created_on DATETIME NOT NULL, INDEX categories_article (categories_id), UNIQUE INDEX title (title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(80) NOT NULL, url VARCHAR(10) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, src VARCHAR(255) NOT NULL, alt VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_image (image_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_B28A764E3DA5256D (image_id), INDEX IDX_B28A764E7294869C (article_id), PRIMARY KEY(image_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE article_image ADD CONSTRAINT FK_B28A764E3DA5256D FOREIGN KEY (image_id) REFERENCES images (id)');
        $this->addSql('ALTER TABLE article_image ADD CONSTRAINT FK_B28A764E7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_image DROP FOREIGN KEY FK_B28A764E7294869C');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66A21214B7');
        $this->addSql('ALTER TABLE article_image DROP FOREIGN KEY FK_B28A764E3DA5256D');
        $this->addSql('DROP TABLE `admin`');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE article_image');
        $this->addSql('DROP TABLE user');
    }
}
