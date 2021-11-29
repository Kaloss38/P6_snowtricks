<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211129184214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trick DROP FOREIGN KEY FK_D8F0A91EA76ED395');
        $this->addSql('ALTER TABLE trick ADD CONSTRAINT FK_D8F0A91E58D797EA FOREIGN KEY (related_group_id) REFERENCES `group` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D8F0A91E5E237E06 ON trick (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D8F0A91E989D9B62 ON trick (slug)');
        $this->addSql('CREATE INDEX IDX_D8F0A91E58D797EA ON trick (related_group_id)');
        $this->addSql('DROP INDEX fk_d8f0a91ea76ed395 ON trick');
        $this->addSql('CREATE INDEX IDX_D8F0A91EA76ED395 ON trick (user_id)');
        $this->addSql('ALTER TABLE trick ADD CONSTRAINT FK_D8F0A91EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trick DROP FOREIGN KEY FK_D8F0A91E58D797EA');
        $this->addSql('DROP INDEX UNIQ_D8F0A91E5E237E06 ON trick');
        $this->addSql('DROP INDEX UNIQ_D8F0A91E989D9B62 ON trick');
        $this->addSql('DROP INDEX IDX_D8F0A91E58D797EA ON trick');
        $this->addSql('ALTER TABLE trick DROP FOREIGN KEY FK_D8F0A91EA76ED395');
        $this->addSql('DROP INDEX idx_d8f0a91ea76ed395 ON trick');
        $this->addSql('CREATE INDEX FK_D8F0A91EA76ED395 ON trick (user_id)');
        $this->addSql('ALTER TABLE trick ADD CONSTRAINT FK_D8F0A91EA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }
}
