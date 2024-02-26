<?php

declare(strict_types=1);

namespace RichId\CookiesRegulationBundle;

use RichCongress\BundleToolbox\Configuration\AbstractBundle;

class RichIdCookiesRegulationBundle extends AbstractBundle
{
    /** @var array<string, string> */
    protected static $doctrineAttributeMapping = [
        'RichId\CookiesRegulationBundle\Entity' => __DIR__ . '/Entity',
    ];
}
