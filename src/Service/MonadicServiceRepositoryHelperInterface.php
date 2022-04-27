<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\RepositoryMonadicHelper\Service;

use Doctrine\Persistence\ObjectRepository;
use Marcosh\LamPHPda\Either;

/**
 * @template L
 * @template R of object
 */
interface MonadicServiceRepositoryHelperInterface
{
    /**
     * @param ObjectRepository<R> $objectRepository
     * @param int|string $id
     *
     * @return Either<L, R>
     */
    public function eitherFind(ObjectRepository $objectRepository, $id): Either;

    /**
     * @param ObjectRepository<R> $objectRepository
     *
     * @return Either<L, list<R>>
     */
    public function eitherFindAll(ObjectRepository $objectRepository): Either;

    /**
     * @param ObjectRepository<R> $objectRepository
     * @param array<string, mixed> $criteria
     * @param null|array<string, 'asc'|'desc'|'ASC'|'DESC'>|null $orderBy
     *
     * @return Either<L, list<R>>
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
