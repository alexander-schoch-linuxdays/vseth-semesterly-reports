<?php

declare(strict_types=1);

/*
 * This file is part of the vseth-semesterly-reports project.
 *
 * (c) Florian Moser <git@famoser.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200321133550 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('ALTER TABLE organisation ADD COLUMN last_visit_at DATETIME DEFAULT NULL');
        $this->addSql('CREATE TEMPORARY TABLE __temp__event AS SELECT id, semester, name_de, name_en, description_de, description_en, location, start_date, end_date, need_financial_support, organisation_id, show_in_calender, revenue, expenditure, created_at, last_changed_at FROM event');
        $this->addSql('DROP TABLE event');
        $this->addSql('CREATE TABLE event (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, organisation_id INTEGER DEFAULT NULL, semester INTEGER NOT NULL, name_de CLOB DEFAULT NULL COLLATE BINARY, name_en CLOB DEFAULT NULL COLLATE BINARY, description_de CLOB DEFAULT NULL COLLATE BINARY, description_en CLOB DEFAULT NULL COLLATE BINARY, location CLOB NOT NULL COLLATE BINARY, start_date DATETIME DEFAULT NULL, end_date DATETIME DEFAULT NULL, need_financial_support BOOLEAN NOT NULL, show_in_calender BOOLEAN DEFAULT \'1\' NOT NULL, revenue INTEGER NOT NULL, expenditure INTEGER NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, last_changed_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CONSTRAINT FK_3BAE0AA79E6B1585 FOREIGN KEY (organisation_id) REFERENCES organisation (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO event (id, semester, name_de, name_en, description_de, description_en, location, start_date, end_date, need_financial_support, organisation_id, show_in_calender, revenue, expenditure, created_at, last_changed_at) SELECT id, semester, name_de, name_en, description_de, description_en, location, start_date, end_date, need_financial_support, organisation_id, show_in_calender, revenue, expenditure, created_at, last_changed_at FROM __temp__event');
        $this->addSql('DROP TABLE __temp__event');
        $this->addSql('CREATE INDEX IDX_3BAE0AA79E6B1585 ON event (organisation_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__semester_report AS SELECT id, semester, submitted_date_time, political_events_description, comments, organisation_id, created_at, last_changed_at FROM semester_report');
        $this->addSql('DROP TABLE semester_report');
        $this->addSql('CREATE TABLE semester_report (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, organisation_id INTEGER DEFAULT NULL, semester INTEGER NOT NULL, submitted_date_time DATETIME NOT NULL, political_events_description CLOB DEFAULT NULL COLLATE BINARY, comments CLOB DEFAULT NULL COLLATE BINARY, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, last_changed_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CONSTRAINT FK_F131FF219E6B1585 FOREIGN KEY (organisation_id) REFERENCES organisation (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO semester_report (id, semester, submitted_date_time, political_events_description, comments, organisation_id, created_at, last_changed_at) SELECT id, semester, submitted_date_time, political_events_description, comments, organisation_id, created_at, last_changed_at FROM __temp__semester_report');
        $this->addSql('DROP TABLE __temp__semester_report');
        $this->addSql('CREATE INDEX IDX_F131FF219E6B1585 ON semester_report (organisation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_3BAE0AA79E6B1585');
        $this->addSql('CREATE TEMPORARY TABLE __temp__event AS SELECT id, organisation_id, semester, name_de, name_en, description_de, description_en, location, start_date, end_date, show_in_calender, revenue, expenditure, need_financial_support, created_at, last_changed_at FROM event');
        $this->addSql('DROP TABLE event');
        $this->addSql('CREATE TABLE event (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, organisation_id INTEGER DEFAULT NULL, semester INTEGER NOT NULL, name_de CLOB DEFAULT NULL, name_en CLOB DEFAULT NULL, description_de CLOB DEFAULT NULL, description_en CLOB DEFAULT NULL, location CLOB NOT NULL, start_date DATETIME DEFAULT NULL, end_date DATETIME DEFAULT NULL, show_in_calender BOOLEAN DEFAULT \'1\' NOT NULL, revenue INTEGER NOT NULL, expenditure INTEGER NOT NULL, need_financial_support BOOLEAN NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, last_changed_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL)');
        $this->addSql('INSERT INTO event (id, organisation_id, semester, name_de, name_en, description_de, description_en, location, start_date, end_date, show_in_calender, revenue, expenditure, need_financial_support, created_at, last_changed_at) SELECT id, organisation_id, semester, name_de, name_en, description_de, description_en, location, start_date, end_date, show_in_calender, revenue, expenditure, need_financial_support, created_at, last_changed_at FROM __temp__event');
        $this->addSql('DROP TABLE __temp__event');
        $this->addSql('CREATE TEMPORARY TABLE __temp__organisation AS SELECT id, name, email, relation_since_semester, comments, authentication_code, created_at, last_changed_at, hidden_at FROM organisation');
        $this->addSql('DROP TABLE organisation');
        $this->addSql('CREATE TABLE organisation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name CLOB NOT NULL, email CLOB NOT NULL, relation_since_semester INTEGER NOT NULL, comments CLOB DEFAULT NULL, authentication_code VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, last_changed_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, hidden_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO organisation (id, name, email, relation_since_semester, comments, authentication_code, created_at, last_changed_at, hidden_at) SELECT id, name, email, relation_since_semester, comments, authentication_code, created_at, last_changed_at, hidden_at FROM __temp__organisation');
        $this->addSql('DROP TABLE __temp__organisation');
        $this->addSql('DROP INDEX IDX_F131FF219E6B1585');
        $this->addSql('CREATE TEMPORARY TABLE __temp__semester_report AS SELECT id, organisation_id, semester, submitted_date_time, political_events_description, comments, created_at, last_changed_at FROM semester_report');
        $this->addSql('DROP TABLE semester_report');
        $this->addSql('CREATE TABLE semester_report (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, organisation_id INTEGER DEFAULT NULL, semester INTEGER NOT NULL, submitted_date_time DATETIME NOT NULL, political_events_description CLOB DEFAULT NULL, comments CLOB DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, last_changed_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL)');
        $this->addSql('INSERT INTO semester_report (id, organisation_id, semester, submitted_date_time, political_events_description, comments, created_at, last_changed_at) SELECT id, organisation_id, semester, submitted_date_time, political_events_description, comments, created_at, last_changed_at FROM __temp__semester_report');
        $this->addSql('DROP TABLE __temp__semester_report');
    }
}
