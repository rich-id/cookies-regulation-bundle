<?php

declare(strict_types=1);

namespace RichId\CookiesRegulationBundle;

use RichCongress\BundleToolbox\Configuration\AbstractBundle;

class RichIdCookiesRegulationBundle extends AbstractBundle
{
    protected static $doctrineAnnotationMapping = [
        'RichId\CookiesRegulationBundle\Entity' => __DIR__ . '/Entity',
    ];
}
