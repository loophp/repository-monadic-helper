<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\RepositoryMonadicHelper\Doctrine;

use Marcosh\LamPHPda\Either;

/**
 * @template L
 * @template R
 */
interface MonadicStandardRepositoryInterface
{
    /**
     * @param int|string $id
     *
     * @return Either<L, R>
     */
    public function find($id): Either;

    /**
     * @return Either<L, list<R>>
     */
    public function findAll(): Either;

    /**
     * @param array<string, mixed> $criteria
     * @param null|array<string, 'asc'|'desc'|'ASC'|'DESC'>|null $orderBy
     *
     * @return Either<L, list<R>>
     */
    public function findBy(
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
    public function findOneBy(
        array $criteria
    ): Either;

    /**
     * @return class-string<R>
     */
    public function getClassName(): string;
}
