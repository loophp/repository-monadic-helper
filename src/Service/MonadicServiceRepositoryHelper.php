<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\RepositoryMonadicHelper\Service;

use Doctrine\Persistence\ObjectRepository;
use loophp\RepositoryMonadicHelper\Exception\MonadicRepositoryException;
use loophp\RepositoryMonadicHelper\Exception\MonadicRepositoryExceptionInterface;
use Marcosh\LamPHPda\Either;
use Marcosh\LamPHPda\Maybe;

/**
 * @template R of object
 *
 * @implements MonadicServiceRepositoryHelperInterface<MonadicRepositoryExceptionInterface, R>
 */
final class MonadicServiceRepositoryHelper implements MonadicServiceRepositoryHelperInterface
{
    public function eitherFind(ObjectRepository $objectRepository, $id): Either
    {
        return Maybe::fromNullable($objectRepository->find($id))
            ->toEither(
                MonadicRepositoryException::entityNotFoundWithSuchId(
                    $objectRepository->getClassName(),
                    (string) $id
                )
            );
    }

    public function eitherFindAll(ObjectRepository $objectRepository): Either
    {
        /** @var list<R> $entities */
        $entities = $objectRepository->findAll();

        return Maybe::fromNullable(([] === $entities) ? null : $entities)
            ->toEither(
                MonadicRepositoryException::entityNotFound(
                    $objectRepository->getClassName()
                )
            );
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

        return Maybe::fromNullable(([] === $entities) ? null : $entities)
            ->toEither(
                MonadicRepositoryException::entityNotFoundWithSuchCriteria(
                    $objectRepository->getClassName(),
                    $criteria
                )
            );
    }

    public function eitherFindOneBy(ObjectRepository $objectRepository, array $criteria): Either
    {
        return Maybe::fromNullable($objectRepository->findOneBy($criteria))
            ->toEither(
                MonadicRepositoryException::entityNotFoundWithSuchCriteria(
                    $objectRepository->getClassName(),
                    $criteria
                )
            );
    }
}
