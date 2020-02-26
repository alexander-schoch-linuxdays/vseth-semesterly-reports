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
final class Version20200226171946 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__organisation AS SELECT id, name, email, relation_since_semester, authentication_code FROM organisation');
        $this->addSql('DROP TABLE organisation');
        $this->addSql('CREATE TABLE organisation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name CLOB NOT NULL COLLATE BINARY, email CLOB NOT NULL COLLATE BINARY, relation_since_semester INTEGER NOT NULL, authentication_code VARCHAR(255) NOT NULL COLLATE BINARY, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, last_changed_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL)');
        $this->addSql('INSERT INTO organisation (id, name, email, relation_since_semester, authentication_code) SELECT id, name, email, relation_since_semester, authentication_code FROM __temp__organisation');
        $this->addSql('DROP TABLE __temp__organisation');
        $this->addSql('CREATE TEMPORARY TABLE __temp__semester_report AS SELECT id, semester, submitted_date_time, political_events_description, comments, organisation_id FROM semester_report');
        $this->addSql('DROP TABLE semester_report');
        $this->addSql('CREATE TABLE semester_report (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, semester INTEGER NOT NULL, submitted_date_time DATETIME NOT NULL, political_events_description CLOB DEFAULT NULL COLLATE BINARY, comments CLOB DEFAULT NULL COLLATE BINARY, organisation_id INTEGER DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, last_changed_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL)');
        $this->addSql('INSERT INTO semester_report (id, semester, submitted_date_time, political_events_description, comments, organisation_id) SELECT id, semester, submitted_date_time, political_events_description, comments, organisation_id FROM __temp__semester_report');
        $this->addSql('DROP TABLE __temp__semester_report');
        $this->addSql('CREATE TEMPORARY TABLE __temp__event AS SELECT id, semester, name_de, name_en, description_de, description_en, location, start_date, end_date, need_financial_support, organisation_id, show_in_calender, revenue, expenditure FROM event');
        $this->addSql('DROP TABLE event');
        $this->addSql('CREATE TABLE event (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, semester INTEGER NOT NULL, name_de CLOB DEFAULT NULL COLLATE BINARY, name_en CLOB DEFAULT NULL COLLATE BINARY, description_de CLOB DEFAULT NULL COLLATE BINARY, description_en CLOB DEFAULT NULL COLLATE BINARY, location CLOB NOT NULL COLLATE BINARY, start_date DATETIME DEFAULT NULL, end_date DATETIME DEFAULT NULL, need_financial_support BOOLEAN NOT NULL, organisation_id INTEGER DEFAULT NULL, show_in_calender BOOLEAN DEFAULT \'1\' NOT NULL, revenue INTEGER NOT NULL, expenditure INTEGER NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, last_changed_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL)');
        $this->addSql('INSERT INTO event (id, semester, name_de, name_en, description_de, description_en, location, start_date, end_date, need_financial_support, organisation_id, show_in_calender, revenue, expenditure) SELECT id, semester, name_de, name_en, description_de, description_en, location, start_date, end_date, need_financial_support, organisation_id, show_in_calender, revenue, expenditure FROM __temp__event');
        $this->addSql('DROP TABLE __temp__event');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__event AS SELECT id, semester, name_de, name_en, description_de, description_en, location, start_date, end_date, show_in_calender, revenue, expenditure, need_financial_support, organisation_id FROM event');
        $this->addSql('DROP TABLE event');
        $this->addSql('CREATE TABLE event (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, semester INTEGER NOT NULL, name_de CLOB DEFAULT NULL, name_en CLOB DEFAULT NULL, description_de CLOB DEFAULT NULL, description_en CLOB DEFAULT NULL, location CLOB NOT NULL, start_date DATETIME DEFAULT NULL, end_date DATETIME DEFAULT NULL, show_in_calender BOOLEAN DEFAULT \'1\' NOT NULL, revenue INTEGER NOT NULL, expenditure INTEGER NOT NULL, need_financial_support BOOLEAN NOT NULL, organisation_id INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO event (id, semester, name_de, name_en, description_de, description_en, location, start_date, end_date, show_in_calender, revenue, expenditure, need_financial_support, organisation_id) SELECT id, semester, name_de, name_en, description_de, description_en, location, start_date, end_date, show_in_calender, revenue, expenditure, need_financial_support, organisation_id FROM __temp__event');
        $this->addSql('DROP TABLE __temp__event');
        $this->addSql('CREATE TEMPORARY TABLE __temp__organisation AS SELECT id, name, email, relation_since_semester, authentication_code FROM organisation');
        $this->addSql('DROP TABLE organisation');
        $this->addSql('CREATE TABLE organisation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name CLOB NOT NULL, email CLOB NOT NULL, relation_since_semester INTEGER NOT NULL, authentication_code VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO organisation (id, name, email, relation_since_semester, authentication_code) SELECT id, name, email, relation_since_semester, authentication_code FROM __temp__organisation');
        $this->addSql('DROP TABLE __temp__organisation');
        $this->addSql('CREATE TEMPORARY TABLE __temp__semester_report AS SELECT id, semester, submitted_date_time, political_events_description, comments, organisation_id FROM semester_report');
        $this->addSql('DROP TABLE semester_report');
        $this->addSql('CREATE TABLE semester_report (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, semester INTEGER NOT NULL, submitted_date_time DATETIME NOT NULL, political_events_description CLOB DEFAULT NULL, comments CLOB DEFAULT NULL, organisation_id INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO semester_report (id, semester, submitted_date_time, political_events_description, comments, organisation_id) SELECT id, semester, submitted_date_time, political_events_description, comments, organisation_id FROM __temp__semester_report');
        $this->addSql('DROP TABLE __temp__semester_report');
    }
}
