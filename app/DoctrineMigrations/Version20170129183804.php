<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170129183804 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE genus_notes DROP FOREIGN KEY FK_B2D619A485C4074C');
        $this->addSql('ALTER TABLE genus_notes CHANGE genus_id genus_id INT NOT NULL');
        $this->addSql('ALTER TABLE genus_notes ADD CONSTRAINT FK_B2D619A485C4074C FOREIGN KEY (genus_id) REFERENCES genuses (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE genus_notes DROP FOREIGN KEY FK_B2D619A485C4074C');
        $this->addSql('ALTER TABLE genus_notes CHANGE genus_id genus_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE genus_notes ADD CONSTRAINT FK_B2D619A485C4074C FOREIGN KEY (genus_id) REFERENCES genuses (id)');
    }
}
