<?php

declare(strict_types=1);

namespace loophp\RepositoryMonadicHelper\Doctrine;

use Doctrine\Persistence\ObjectRepository;
use Marcosh\LamPHPda\Either;

/**
 * @template L
 * @template R of object
 *
 * @extends ObjectRepository<R>
 */
interface MonadicServiceEntityRepositoryInterface extends ObjectRepository
{
    /**
     * @return Either<L, R>
     */
    public function eitherFind(int|string $id): Either;

    /**
     * @return Either<L, array<R>>
     */
    public function eitherFindAll(): Either;

    /**
     * @param array<string, mixed> $criteria
     * @param null|array<string, 'asc'|'desc'|'ASC'|'DESC'>|null $orderBy
     *
     * @return Either<L, array<R>>
     */
    public function eitherFindBy(
        array $criteria,
        ?array $orderBy = null,
        ?int $limit = null,
        ?int $offset = null
    ): Either;

    /**
     * @param array<string, mixed> $criteria
     *
     * @return Either<L, R>
     */
    public function eitherFindOneBy(array $criteria): Either;
}
