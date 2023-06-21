<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230621161139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, projet_id INT NOT NULL, role VARCHAR(255) NOT NULL, INDEX IDX_5E90F6D6A76ED395 (user_id), INDEX IDX_5E90F6D6C18272 (projet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6C18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE user_projet DROP FOREIGN KEY FK_35478794A76ED395');
        $this->addSql('ALTER TABLE user_projet DROP FOREIGN KEY FK_35478794C18272');
        $this->addSql('DROP TABLE user_projet');
        $this->addSql('ALTER TABLE projet ADD owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA97E3C61F9 FOREIGN KEY (owner_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_50159CA97E3C61F9 ON projet (owner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_projet (user_id INT NOT NULL, projet_id INT NOT NULL, INDEX IDX_35478794A76ED395 (user_id), INDEX IDX_35478794C18272 (projet_id), PRIMARY KEY(user_id, projet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_projet ADD CONSTRAINT FK_35478794A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_projet ADD CONSTRAINT FK_35478794C18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6A76ED395');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6C18272');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA97E3C61F9');
        $this->addSql('DROP INDEX IDX_50159CA97E3C61F9 ON projet');
        $this->addSql('ALTER TABLE projet DROP owner_id');
    }
}
