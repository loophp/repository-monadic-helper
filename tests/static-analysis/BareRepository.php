<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

use tests\loophp\RepositoryMonadicHelper\App\Entity\CustomEntity;
use tests\loophp\RepositoryMonadicHelper\App\Repository\BareCustomEntityRepository;

include __DIR__ . '/../../vendor/autoload.php';

function testFind(?CustomEntity $entity): void
{
};

$repository = new BareCustomEntityRepository();

testFind($repository->find(123));
