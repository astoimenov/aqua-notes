<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170202090819 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sub_family (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE genuses ADD sub_family_id INT NOT NULL, DROP sub_family');
        $this->addSql('ALTER TABLE genuses ADD CONSTRAINT FK_7696C313D15310D4 FOREIGN KEY (sub_family_id) REFERENCES sub_family (id)');
        $this->addSql('CREATE INDEX IDX_7696C313D15310D4 ON genuses (sub_family_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE genuses DROP FOREIGN KEY FK_7696C313D15310D4');
        $this->addSql('DROP TABLE sub_family');
        $this->addSql('DROP INDEX IDX_7696C313D15310D4 ON genuses');
        $this->addSql('ALTER TABLE genuses ADD sub_family VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, DROP sub_family_id');
    }
}
