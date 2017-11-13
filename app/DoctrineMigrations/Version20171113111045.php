<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171113111045 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cron_job (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, command VARCHAR(255) NOT NULL, schedule VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, UNIQUE INDEX un_name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cron_report (id INT AUTO_INCREMENT NOT NULL, job_id INT DEFAULT NULL, run_at DATETIME NOT NULL, run_time DOUBLE PRECISION NOT NULL, exit_code INT NOT NULL, output LONGTEXT NOT NULL, INDEX IDX_B6C6A7F5BE04EA9 (job_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE url (id INT AUTO_INCREMENT NOT NULL, url_info_id INT DEFAULT NULL, url VARCHAR(255) NOT NULL, short_url VARCHAR(255) NOT NULL, created DATETIME NOT NULL, UNIQUE INDEX UNIQ_F47645AE83360531 (short_url), UNIQUE INDEX UNIQ_F47645AEE0F897A4 (url_info_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE url_info (id INT AUTO_INCREMENT NOT NULL, ip VARCHAR(15) NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, screenshot VARCHAR(255) NOT NULL, created DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visit (id INT AUTO_INCREMENT NOT NULL, url_id INT DEFAULT NULL, ip VARCHAR(15) NOT NULL, visited DATETIME NOT NULL, INDEX IDX_437EE93981CFDAE7 (url_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cron_report ADD CONSTRAINT FK_B6C6A7F5BE04EA9 FOREIGN KEY (job_id) REFERENCES cron_job (id)');
        $this->addSql('ALTER TABLE url ADD CONSTRAINT FK_F47645AEE0F897A4 FOREIGN KEY (url_info_id) REFERENCES url_info (id)');
        $this->addSql('ALTER TABLE visit ADD CONSTRAINT FK_437EE93981CFDAE7 FOREIGN KEY (url_id) REFERENCES url (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cron_report DROP FOREIGN KEY FK_B6C6A7F5BE04EA9');
        $this->addSql('ALTER TABLE visit DROP FOREIGN KEY FK_437EE93981CFDAE7');
        $this->addSql('ALTER TABLE url DROP FOREIGN KEY FK_F47645AEE0F897A4');
        $this->addSql('DROP TABLE cron_job');
        $this->addSql('DROP TABLE cron_report');
        $this->addSql('DROP TABLE url');
        $this->addSql('DROP TABLE url_info');
        $this->addSql('DROP TABLE visit');
    }
}
