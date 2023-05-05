<?php

declare(strict_types=1);

use loophp\RepositoryMonadicHelper\Service\MonadicServiceRepositoryHelper;
use Marcosh\LamPHPda\Either;
use tests\loophp\RepositoryMonadicHelper\App\Entity\CustomEntity;
use tests\loophp\RepositoryMonadicHelper\App\Repository\BareCustomEntityRepository;
use Throwable;

include __DIR__ . '/../../vendor/autoload.php';

/** @var MonadicServiceRepositoryHelper<CustomEntity> $helper */
$helper = new MonadicServiceRepositoryHelper();
$repository = new BareCustomEntityRepository();

/**
 * @param Either<Throwable, CustomEntity> $either
 */
function testEitherFind1(Either $either): void
{
};

/**
 * @param Either<Throwable, array<CustomEntity>> $either
 */
function testEitherFindAll1(Either $either): void
{
};

testEitherFind1($helper->eitherFind($repository, 123));
testEitherFind1($helper->eitherFindOneBy($repository, []));
testEitherFindAll1($helper->eitherFindAll($repository));
testEitherFindAll1($helper->eitherFindBy($repository, []));
