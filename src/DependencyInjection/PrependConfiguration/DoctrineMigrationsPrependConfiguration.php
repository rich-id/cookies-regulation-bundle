<?php

declare(strict_types=1);

namespace RichId\CookiesRegulationBundle\DependencyInjection\PrependConfiguration;

use RichCongress\BundleToolbox\Configuration\PrependConfiguration\AbstractDoctrineMigrationPrependConfiguration;

final class DoctrineMigrationsPrependConfiguration extends AbstractDoctrineMigrationPrependConfiguration
{
    protected function getBindings(): array
    {
        return [
            'RichId\CookiesRegulationBundle\Migrations' => '@RichIdCookiesRegulationBundle/Migrations',
        ];
    }
}
