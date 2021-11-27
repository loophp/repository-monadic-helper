<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\RepositoryMonadicHelper\Doctrine;

use Doctrine\Persistence\ObjectRepository;
use Marcosh\LamPHPda\Either;

/**
 * @template L
 * @template R
 *
 * @extends ObjectRepository<R>
 */
interface MonadicServiceEntityRepositoryInterface extends ObjectRepository
{
    /**
     * @param int|string $id
     *
     * @return Either<L, R>
     */
    public function eitherFind($id): Either;

    /**
     * @return Either<L, list<R>>
     */
    public function eitherFindAll(): Either;

    /**
     * @param array<string, mixed> $criteria
     * @param null|array<string, 'asc'|'desc'|'ASC'|'DESC'>|null $orderBy
     *
     * @return Either<L, list<R>>
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
