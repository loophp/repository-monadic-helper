<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\RepositoryMonadicHelper;

use Marcosh\LamPHPda\Either;
use Throwable;

/**
 * @template L of Throwable
 * @template R of object
 */
interface MonadicServiceRepositoryInterface
{
    /**
     * @param mixed $id
     *
     * @return Either<L, R>
     */
    public function eitherFind($id): Either;

    /**
     * @return Either<L, R>
     */
    public function eitherFindOneBy(array $criteria, ?array $orderBy = null): Either;

    /**
     * @param mixed $id
     *
     * @return R|null The object
     */
    public function find($id);

    /**
     * @return list<R> The objects
     */
    public function findAll();

    /**
     * @param array<string, mixed> $criteria
     * @param array<string, 'asc'|'desc'|'ASC'|'DESC'>|null $orderBy
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return list<R> The objects
     */
    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null);

    /**
     * @return R|null The object
     */
    public function findOneBy(array $criteria);
}
