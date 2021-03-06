<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210814154123 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('INSERT INTO publisher (name, value, country, year) 
                            VALUES ("Valve", "10bn", "USA", 1996)');
        $this->addSql('INSERT INTO game (name, year, publisher_id) 
                            VALUES ("Half-Life", 1998, 3)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DELETE FROM game WHERE name="Half-Life"');
        $this->addSql('DELETE FROM publisher WHERE name="Valve"');
    }
}
