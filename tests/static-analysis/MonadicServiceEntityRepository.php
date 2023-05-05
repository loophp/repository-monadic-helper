<?php

declare(strict_types=1);

use Marcosh\LamPHPda\Either;
use tests\loophp\RepositoryMonadicHelper\App\Entity\CustomEntity;
use tests\loophp\RepositoryMonadicHelper\App\Repository\MonadicBareCustomEntityRepository;
use Throwable;

include __DIR__ . '/../../vendor/autoload.php';

$repository = new MonadicBareCustomEntityRepository();

/**
 * @param Either<Throwable, CustomEntity> $either
 */
function testEitherFind(Either $either): void
{
};

/**
 * @param Either<Throwable, array<CustomEntity>> $either
 */
function testEitherFindAll(Either $either): void
{
};

testEitherFind($repository->eitherFind(123));
testEitherFind($repository->eitherFindOneBy([]));
testEitherFindAll($repository->eitherFindAll());
testEitherFindAll($repository->eitherFindBy([]));
