<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220329135606 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE answer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE patient_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE video_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE answer (id INT NOT NULL, patient_id INT NOT NULL, video_id INT NOT NULL, answer VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, success BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DADD4A256B899279 ON answer (patient_id)');
        $this->addSql('CREATE INDEX IDX_DADD4A2529C1004E ON answer (video_id)');
        $this->addSql('COMMENT ON COLUMN answer.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE patient (id INT NOT NULL, email VARCHAR(255) NOT NULL, referer_first_name VARCHAR(255) DEFAULT NULL, referer_last_name VARCHAR(255) DEFAULT NULL, patient_first_name VARCHAR(255) NOT NULL, patient_last_name VARCHAR(255) NOT NULL, token VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE video (id INT NOT NULL, category_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, commentary TEXT DEFAULT NULL, link VARCHAR(255) NOT NULL, published BOOLEAN NOT NULL, false_response_one VARCHAR(255) NOT NULL, false_response_two VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7CC7DA2C12469DE2 ON video (category_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A256B899279 FOREIGN KEY (patient_id) REFERENCES patient (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A2529C1004E FOREIGN KEY (video_id) REFERENCES video (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2C12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE video DROP CONSTRAINT FK_7CC7DA2C12469DE2');
        $this->addSql('ALTER TABLE answer DROP CONSTRAINT FK_DADD4A256B899279');
        $this->addSql('ALTER TABLE answer DROP CONSTRAINT FK_DADD4A2529C1004E');
        $this->addSql('DROP SEQUENCE answer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE patient_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE video_id_seq CASCADE');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE video');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
