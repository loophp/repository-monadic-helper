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
 * @template R
 *
 * @implements MonadicServiceRepositoryHelperInterface<Throwable, R>
 */
final class MonadicServiceRepositoryHelper implements MonadicServiceRepositoryHelperInterface
{
    public function eitherFind(ObjectRepository $objectRepository, $id): Either
    {
        return (null === $entity = $objectRepository->find($id))
            ? Either::left(
                MonadicRepositoryException::entityNotFoundWithSuchId(
                    $objectRepository->getClassName(),
                    (string) $id
                )
            )
            : Either::right($entity);
    }

    public function eitherFindAll(ObjectRepository $objectRepository): Either
    {
        return ([] === $entities = $objectRepository->findAll())
            ? Either::left(
                MonadicRepositoryException::entityNotFound(
                    $objectRepository->getClassName()
                )
            )
            : Either::right($entities);
    }

    public function eitherFindBy(
        ObjectRepository $objectRepository,
        array $criteria,
        ?array $orderBy = null,
        ?int $limit = null,
        ?int $offset = null
    ): Either {
        return ([] === $entities = $objectRepository->findBy($criteria, $orderBy, $limit, $offset))
            ? Either::left(
                MonadicRepositoryException::entityNotFoundWithSuchCriteria(
                    $objectRepository->getClassName(),
                    $criteria
                )
            )
            : Either::right($entities);
    }

    public function eitherFindOneBy(ObjectRepository $objectRepository, array $criteria): Either
    {
        return (null === $entity = $objectRepository->findOneBy($criteria))
            ? Either::left(
                MonadicRepositoryException::entityNotFoundWithSuchCriteria(
                    $objectRepository->getClassName(),
                    $criteria
                )
            )
            : Either::right($entity);
    }
}
