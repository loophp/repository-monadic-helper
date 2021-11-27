<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

use loophp\RepositoryMonadicHelper\Service\MonadicServiceRepositoryHelper;
use loophp\RepositoryMonadicHelper\Service\MonadicServiceRepositoryHelperInterface;
use Marcosh\LamPHPda\Either;
use tests\loophp\RepositoryMonadicHelper\App\Entity\CustomEntity;
use tests\loophp\RepositoryMonadicHelper\App\Repository\BareCustomEntityRepository;
use Throwable;

include __DIR__ . '/../../vendor/autoload.php';

/** @var MonadicServiceRepositoryHelperInterface<Throwable, CustomEntity> $helper */
$helper = new MonadicServiceRepositoryHelper();
$repository = new BareCustomEntityRepository();

/**
 * @param Either<Throwable, CustomEntity> $either
 */
function testEitherFind1(Either $either): void
{
};

/**
 * @param Either<Throwable, list<CustomEntity>> $either
 */
function testEitherFindAll1(Either $either): void
{
};

testEitherFind1($helper->eitherFind($repository, 123));
testEitherFind1($helper->eitherFindOneBy($repository, []));
testEitherFindAll1($helper->eitherFindAll($repository));
testEitherFindAll1($helper->eitherFindBy($repository, []));
