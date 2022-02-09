<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220209054209 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE migrations_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE failed_jobs_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE promocode_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE promocode (id INT NOT NULL, keyword VARCHAR(255) NOT NULL, discount_percent DOUBLE PRECISION NOT NULL, number_of_uses INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE migrations');
        $this->addSql('DROP TABLE password_resets');
        $this->addSql('DROP TABLE failed_jobs');
        $this->addSql('DROP TABLE users');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE promocode_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE migrations_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE failed_jobs_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE migrations (id SERIAL NOT NULL, migration VARCHAR(255) NOT NULL, batch INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE password_resets (email VARCHAR(255) NOT NULL, token VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL)');
        $this->addSql('CREATE INDEX password_resets_email_index ON password_resets (email)');
        $this->addSql('CREATE TABLE failed_jobs (id BIGSERIAL NOT NULL, uuid VARCHAR(255) NOT NULL, connection TEXT NOT NULL, queue TEXT NOT NULL, payload TEXT NOT NULL, exception TEXT NOT NULL, failed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX failed_jobs_uuid_unique ON failed_jobs (uuid)');
        $this->addSql('CREATE TABLE users (id BIGSERIAL NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_verified_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, password VARCHAR(255) NOT NULL, remember_token VARCHAR(100) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX users_email_unique ON users (email)');
        $this->addSql('DROP TABLE promocode');
    }
}
