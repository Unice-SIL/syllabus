<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src/Syllabus/Entity'
    ])
    ->withPreparedSets(deadCode: true, codeQuality: true)
    ->withAttributesSets(symfony: true, doctrine: true)
    // uncomment to reach your current PHP version
    // ->withPhpSets()
    ->withTypeCoverageLevel(0);
