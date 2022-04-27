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
        if (null === $entity = $objectRepository->find($id)) {
            /** @var Either<L, R> $either */
            $either = Either::left(
                MonadicRepositoryException::entityNotFoundWithSuchId(
                    $objectRepository->getClassName(),
                    (string) $id
                )
            );

            return $either;
        }

        return Either::right($entity);
    }

    public function eitherFindAll(ObjectRepository $objectRepository): Either
    {
        if ([] === $entities = $objectRepository->findAll()) {
            /** @var Either<L, list<R>> $either */
            $either = Either::left(
                MonadicRepositoryException::entityNotFound(
                    $objectRepository->getClassName()
                )
            );

            return $either;
        }

        /** @var Either<L, list<R>> $either */
        $either = Either::right($entities);

        return $either;
    }

    public function eitherFindBy(
        ObjectRepository $objectRepository,
        array $criteria,
        ?array $orderBy = null,
        ?int $limit = null,
        ?int $offset = null
    ): Either {
        if ([] === $entities = $objectRepository->findBy($criteria, $orderBy, $limit, $offset)) {
            /** @var Either<L, list<R>> $either */
            $either = Either::left(
                MonadicRepositoryException::entityNotFoundWithSuchCriteria(
                    $objectRepository->getClassName(),
                    $criteria
                )
            );

            return $either;
        }

        /** @var Either<L, list<R>> $either */
        $either = Either::right($entities);

        return $either;
    }

    public function eitherFindOneBy(ObjectRepository $objectRepository, array $criteria): Either
    {
        if (null === $entity = $objectRepository->findOneBy($criteria)) {
            /** @var Either<L, R> $either */
            $either = Either::left(
                MonadicRepositoryException::entityNotFoundWithSuchCriteria(
                    $objectRepository->getClassName(),
                    $criteria
                )
            );

            return $either;
        }

        return Either::right($entity);
    }
}
