<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201220174005 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE target DROP FOREIGN KEY FK_466F2FFC9D86650F');
        $this->addSql('DROP INDEX IDX_466F2FFC9D86650F ON target');
        $this->addSql('ALTER TABLE target CHANGE user_id_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT FK_466F2FFCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_466F2FFCA76ED395 ON target (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE target DROP FOREIGN KEY FK_466F2FFCA76ED395');
        $this->addSql('DROP INDEX IDX_466F2FFCA76ED395 ON target');
        $this->addSql('ALTER TABLE target CHANGE user_id user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE target ADD CONSTRAINT FK_466F2FFC9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_466F2FFC9D86650F ON target (user_id_id)');
    }
}
