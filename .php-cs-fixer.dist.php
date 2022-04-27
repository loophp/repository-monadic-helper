<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

use drupol\PhpCsFixerConfigsPhp\Config\Php73;

$config = new Php73();

$config
    ->getFinder()
    ->ignoreDotFiles(false)
    ->name(['.php-cs-fixer.dist.php']);

$rules = $config->getRules();

$rules['return_assignment'] = false;

return $config->setRules($rules);
