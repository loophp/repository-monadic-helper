<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\RepositoryMonadicHelper\Service;

use Doctrine\Persistence\ObjectRepository;
use loophp\RepositoryMonadicHelper\Exception\MonadicRepositoryException;
use Marcosh\LamPHPda\Either;
use Marcosh\LamPHPda\Maybe;
use Throwable;

/**
 * @template L of Throwable
 * @template R of object
 *
 * @implements MonadicServiceRepositoryHelperInterface<L, R>
 */
final class MonadicServiceRepositoryHelper implements MonadicServiceRepositoryHelperInterface
{
    public function eitherFind(ObjectRepository $objectRepository, $id): Either
    {
        /** @var Either<L, R> $either */
        $either = Maybe::fromNullable($objectRepository->find($id))
            ->toEither(
                MonadicRepositoryException::entityNotFoundWithSuchId(
                    $objectRepository->getClassName(),
                    (string) $id
                )
            );

        return $either;
    }

    public function eitherFindAll(ObjectRepository $objectRepository): Either
    {
        /** @var list<R> $entities */
        $entities = $objectRepository->findAll();

        /** @var Either<L, list<R>> $either */
        $either = Maybe::fromNullable(([] === $entities) ? null : $entities)
            ->toEither(
                MonadicRepositoryException::entityNotFound(
                    $objectRepository->getClassName()
                )
            );

        return $either;
    }

    public function eitherFindBy(
        ObjectRepository $objectRepository,
        array $criteria,
        ?array $orderBy = null,
        ?int $limit = null,
        ?int $offset = null
    ): Either {
        /** @var list<R> $entities */
        $entities = $objectRepository->findBy($criteria, $orderBy, $limit, $offset);

        /** @var Either<L, list<R>> $either */
        $either = Maybe::fromNullable(([] === $entities) ? null : $entities)
            ->toEither(
                MonadicRepositoryException::entityNotFoundWithSuchCriteria(
                    $objectRepository->getClassName(),
                    $criteria
                )
            );

        return $either;
    }

    public function eitherFindOneBy(ObjectRepository $objectRepository, array $criteria): Either
    {
        /** @var Either<L, R> $either */
        $either = Maybe::fromNullable($objectRepository->findOneBy($criteria))
            ->toEither(
                MonadicRepositoryException::entityNotFoundWithSuchCriteria(
                    $objectRepository->getClassName(),
                    $criteria
                )
            );

        return $either;
    }
}
