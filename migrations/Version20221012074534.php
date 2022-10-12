<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221012074534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__property AS SELECT id, user_id, title, content, transaction_type, size, ground_size, rooms, floor, address, postal_code, city, price, property_type, picture, available FROM property');
        $this->addSql('DROP TABLE property');
        $this->addSql('CREATE TABLE property (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, title VARCHAR(100) NOT NULL, content CLOB NOT NULL, transaction_type BOOLEAN NOT NULL, size INTEGER NOT NULL, ground_size INTEGER DEFAULT NULL, rooms INTEGER NOT NULL, floor INTEGER DEFAULT NULL, address VARCHAR(255) NOT NULL, postal_code VARCHAR(10) NOT NULL, city VARCHAR(100) NOT NULL, price INTEGER NOT NULL, property_type INTEGER NOT NULL, picture VARCHAR(40) DEFAULT NULL, available BOOLEAN DEFAULT 1 NOT NULL, CONSTRAINT FK_8BF21CDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO property (id, user_id, title, content, transaction_type, size, ground_size, rooms, floor, address, postal_code, city, price, property_type, picture, available) SELECT id, user_id, title, content, transaction_type, size, ground_size, rooms, floor, address, postal_code, city, price, property_type, picture, available FROM __temp__property');
        $this->addSql('DROP TABLE __temp__property');
        $this->addSql('CREATE INDEX IDX_8BF21CDEA76ED395 ON property (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__property AS SELECT id, user_id, title, content, transaction_type, size, ground_size, rooms, floor, address, postal_code, city, price, property_type, picture, available FROM property');
        $this->addSql('DROP TABLE property');
        $this->addSql('CREATE TABLE property (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, title VARCHAR(100) NOT NULL, content CLOB NOT NULL, transaction_type BOOLEAN NOT NULL, size INTEGER NOT NULL, ground_size INTEGER DEFAULT NULL, rooms INTEGER NOT NULL, floor INTEGER DEFAULT NULL, address VARCHAR(255) NOT NULL, postal_code VARCHAR(10) NOT NULL, city VARCHAR(100) NOT NULL, price INTEGER NOT NULL, property_type INTEGER NOT NULL, picture VARCHAR(40) DEFAULT NULL, available BOOLEAN DEFAULT 0 NOT NULL, CONSTRAINT FK_8BF21CDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO property (id, user_id, title, content, transaction_type, size, ground_size, rooms, floor, address, postal_code, city, price, property_type, picture, available) SELECT id, user_id, title, content, transaction_type, size, ground_size, rooms, floor, address, postal_code, city, price, property_type, picture, available FROM __temp__property');
        $this->addSql('DROP TABLE __temp__property');
        $this->addSql('CREATE INDEX IDX_8BF21CDEA76ED395 ON property (user_id)');
    }
}
