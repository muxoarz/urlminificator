<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180901105403 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE url_click ADD url_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE url_click ADD CONSTRAINT FK_7F52AD5781CFDAE7 FOREIGN KEY (url_id) REFERENCES url (id)');
        $this->addSql('CREATE INDEX IDX_7F52AD5781CFDAE7 ON url_click (url_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE url_click DROP FOREIGN KEY FK_7F52AD5781CFDAE7');
        $this->addSql('DROP INDEX IDX_7F52AD5781CFDAE7 ON url_click');
        $this->addSql('ALTER TABLE url_click DROP url_id');
    }
}
