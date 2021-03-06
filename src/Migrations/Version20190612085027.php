<?php

declare(strict_types=1);

/*
 * This file is part of the package t3g/intercept.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 * @codeCoverageIgnore
 */
final class Version20190612085027 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('ALTER TABLE documentation_jar ADD COLUMN new BOOLEAN DEFAULT \'0\' NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__documentation_jar AS SELECT id, repository_url, public_composer_json_url, vendor, name, package_name, package_type, extension_key, branch, created_at, last_rendered_at, target_branch_directory, type_long, type_short, minimum_typo_version, maximum_typo_version, status, build_key, re_render_needed FROM documentation_jar');
        $this->addSql('DROP TABLE documentation_jar');
        $this->addSql('CREATE TABLE documentation_jar (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, repository_url VARCHAR(255) NOT NULL, public_composer_json_url VARCHAR(255) DEFAULT \'\' NOT NULL, vendor VARCHAR(255) DEFAULT \'\' NOT NULL, name VARCHAR(255) DEFAULT \'\' NOT NULL, package_name VARCHAR(255) NOT NULL, package_type VARCHAR(255) NOT NULL, branch VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL --(DC2Type:datetime)
        , last_rendered_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL --(DC2Type:datetime)
        , target_branch_directory VARCHAR(255) NOT NULL, type_long VARCHAR(255) DEFAULT \'\' NOT NULL, type_short VARCHAR(255) DEFAULT \'\' NOT NULL, minimum_typo_version VARCHAR(20) DEFAULT \'\' NOT NULL, maximum_typo_version VARCHAR(20) DEFAULT \'\' NOT NULL, status INTEGER DEFAULT 0 NOT NULL, build_key VARCHAR(255) DEFAULT \'\' NOT NULL, re_render_needed BOOLEAN DEFAULT \'0\' NOT NULL, extension_key VARCHAR(255) NOT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO documentation_jar (id, repository_url, public_composer_json_url, vendor, name, package_name, package_type, extension_key, branch, created_at, last_rendered_at, target_branch_directory, type_long, type_short, minimum_typo_version, maximum_typo_version, status, build_key, re_render_needed) SELECT id, repository_url, public_composer_json_url, vendor, name, package_name, package_type, extension_key, branch, created_at, last_rendered_at, target_branch_directory, type_long, type_short, minimum_typo_version, maximum_typo_version, status, build_key, re_render_needed FROM __temp__documentation_jar');
        $this->addSql('DROP TABLE __temp__documentation_jar');
    }
}
