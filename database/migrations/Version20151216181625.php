<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20151216181625 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE attachment CHANGE type type ENUM(\'CV\',\'VIDEO\',\'COVERLETTER\',\'REFERENCE\',\'CERTIFICATE\')');
        $this->addSql('ALTER TABLE school CHANGE type type ENUM(\'HIGH_SCHOOL\', \'UNIVERSITY\',\'INSTITUTION\')');
        $this->addSql('ALTER TABLE user CHANGE gender gender ENUM(\'M\', \'F\'), CHANGE type type ENUM(\'USER\', \'COMPANY\',\'ADMINISTRATOR\',\'ANALYTICS\')');
        $this->addSql('ALTER TABLE vacancy CHANGE seniority seniority ENUM(\'INTERN_STAGE\', \'JUNIOR\',\'MID\',\'SENIOR\')');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE attachment CHANGE type type VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE school CHANGE type type VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE user CHANGE gender gender VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE type type VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE vacancy CHANGE seniority seniority VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
