<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210913150139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE publisher CHANGE year year TINYTEXT');
        $this->addSql('UPDATE publisher SET year = NULL');
        $this->addSql('ALTER TABLE publisher CHANGE year year DATE');
        $this->addSql('UPDATE publisher SET year = CURRENT_DATE');

        $this->addSql('ALTER TABLE game CHANGE is_deleted is_deleted TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE publisher CHANGE is_deleted is_deleted TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('UPDATE publisher SET year = NULL');
        $this->addSql('ALTER TABLE publisher CHANGE year year INT');
        $this->addSql('UPDATE publisher SET year = 0');
        $this->addSql('ALTER TABLE publisher CHANGE year year INT NOT NULL');

        $this->addSql('ALTER TABLE game CHANGE is_deleted is_deleted TINYINT(1) DEFAULT \'0\'');
        $this->addSql('ALTER TABLE publisher CHANGE is_deleted is_deleted TINYINT(1) DEFAULT \'0\'');
    }
}
