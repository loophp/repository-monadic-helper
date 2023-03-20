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
use Throwable;

/**
 * @template R of object
 *
 * @implements MonadicServiceRepositoryHelperInterface<MonadicRepositoryExceptionInterface, R>
 */
final class MonadicServiceRepositoryHelper implements MonadicServiceRepositoryHelperInterface
{
    public function eitherFind(ObjectRepository $objectRepository, int|string $id): Either
    {
        try {
            $maybeEntity = $objectRepository->find($id);
        } catch (Throwable $exception) {
            $exception = MonadicRepositoryException::entityNotFoundWithSuchId(
                $objectRepository->getClassName(),
                (string) $id,
                (int) $exception->getCode(),
                $exception
            );
        }

        return Maybe::fromNullable($maybeEntity ?? null)
            ->toEither(
                $exception ?? MonadicRepositoryException::entityNotFoundWithSuchId(
                    $objectRepository->getClassName(),
                    (string) $id
                )
            );
    }

    public function eitherFindAll(ObjectRepository $objectRepository): Either
    {
        $entities = [];

        try {
            $entities = $objectRepository->findAll();
        } catch (Throwable $exception) {
            $exception = MonadicRepositoryException::entityNotFound(
                $objectRepository->getClassName(),
                (int) $exception->getCode(),
                $exception
            );
        }

        return Maybe::fromNullable(([] === $entities) ? null : $entities)
            ->toEither(
                $exception ?? MonadicRepositoryException::entityNotFound(
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
        $entities = [];

        try {
            $entities = $objectRepository->findBy($criteria, $orderBy, $limit, $offset);
        } catch (Throwable $exception) {
            $exception = MonadicRepositoryException::entityNotFoundWithSuchCriteria(
                $objectRepository->getClassName(),
                $criteria,
                (int) $exception->getCode(),
                $exception
            );
        }

        return Maybe::fromNullable(([] === $entities) ? null : $entities)
            ->toEither(
                $exception ?? MonadicRepositoryException::entityNotFoundWithSuchCriteria(
                    $objectRepository->getClassName(),
                    $criteria
                )
            );
    }

    public function eitherFindOneBy(ObjectRepository $objectRepository, array $criteria): Either
    {
        try {
            $maybeEntity = $objectRepository->findOneBy($criteria);
        } catch (Throwable $exception) {
            $exception = MonadicRepositoryException::entityNotFoundWithSuchCriteria(
                $objectRepository->getClassName(),
                $criteria,
                (int) $exception->getCode(),
                $exception
            );
        }

        return Maybe::fromNullable($maybeEntity ?? null)
            ->toEither(
                $exception ?? MonadicRepositoryException::entityNotFoundWithSuchCriteria(
                    $objectRepository->getClassName(),
                    $criteria
                )
            );
    }
}
