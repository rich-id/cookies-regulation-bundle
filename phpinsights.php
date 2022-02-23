<?php

declare(strict_types=1);

$config = require 'vendor/richcongress/static-analysis/configs/phpinsights.php';

$config['remove'][] = \NunoMaduro\PhpInsights\Domain\Insights\Composer\ComposerLockMustBeFresh::class;

return $config;
