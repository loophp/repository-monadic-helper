<?php

declare(strict_types=1);

namespace loophp\RepositoryMonadicHelper\Service;

use Doctrine\Persistence\ObjectRepository;
use Marcosh\LamPHPda\Either;
use Throwable;

/**
 * @template L of Throwable
 * @template R of object
 */
interface MonadicServiceRepositoryHelperInterface
{
    /**
     * @param ObjectRepository<R> $objectRepository
     *
     * @return Either<L, R>
     */
    public function eitherFind(ObjectRepository $objectRepository, int|string $id): Either;

    /**
     * @param ObjectRepository<R> $objectRepository
     *
     * @return Either<L, array<R>>
     */
    public function eitherFindAll(ObjectRepository $objectRepository): Either;

    /**
     * @param ObjectRepository<R> $objectRepository
     * @param array<string, mixed> $criteria
     * @param null|array<string, 'asc'|'desc'|'ASC'|'DESC'>|null $orderBy
     *
     * @return Either<L, array<R>>
     */
    public function eitherFindBy(
        ObjectRepository $objectRepository,
        array $criteria,
        ?array $orderBy = null,
        ?int $limit = null,
        ?int $offset = null
    ): Either;

    /**
     * @param ObjectRepository<R> $objectRepository
     * @param array<string, mixed> $criteria
     *
     * @return Either<L, R>
     */
    public function eitherFindOneBy(
        ObjectRepository $objectRepository,
        array $criteria
    ): Either;
}
