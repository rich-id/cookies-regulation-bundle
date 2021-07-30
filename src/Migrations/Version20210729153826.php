<?php

declare(strict_types=1);

namespace RichId\CookiesRegulationBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210729153826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add DecisionLog entity';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE cookies_regulation_decision_log (id INT AUTO_INCREMENT NOT NULL, uuid VARCHAR(50) NOT NULL, date DATETIME NOT NULL, service_name VARCHAR(50) NOT NULL, is_enabled TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE cookies_regulation_decision_log');
    }
}
