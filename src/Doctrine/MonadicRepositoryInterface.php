<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\RepositoryMonadicHelper\Doctrine;

use Marcosh\LamPHPda\Either;
use Throwable;

/**
 * @template L of Throwable
 * @template R of object
 */
interface MonadicRepositoryInterface
{
    /**
     * @param int|string $id
     *
     * @return Either<L, R>
     */
    public function eitherFind($id): Either;

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
    public function eitherFindOneBy(
        array $criteria
    ): Either;

    /**
     * @return class-string<R>
     */
    public function getClassName(): string;
}
