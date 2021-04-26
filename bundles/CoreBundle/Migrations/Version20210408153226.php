<?php

declare(strict_types=1);

namespace Pimcore\Bundle\CoreBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190102153226 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->addSql("ALTER TABLE `versions` ADD `autoSave` TINYINT(4) NOT NULL DEFAULT 0");
        $this->addSql('ALTER TABLE `versions` ADD INDEX `autoSave` (`autoSave`)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE `versions` DROP COLUMN `autoSave`');
    }
}