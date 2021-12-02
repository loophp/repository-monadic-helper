<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\RepositoryMonadicHelper\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use loophp\RepositoryMonadicHelper\Exception\MonadicRepositoryException;
use Marcosh\LamPHPda\Either;

/**
 * @template L
 * @template R
 *
 * @implements MonadicStandardRepositoryInterface<L, R>
 */
final class MonadicStandardRepository implements MonadicStandardRepositoryInterface
{
    /**
     * @var ObjectRepository<R>
     */
    private ObjectRepository $objectRepository;

    /**
     * @param class-string<R> $entityClass
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        string $entityClass
    ) {
        $this->objectRepository = $entityManager->getRepository($entityClass);
    }

    public function find($id): Either
    {
        return (null === $entity = $this->objectRepository->find($id))
            ? Either::left(
                MonadicRepositoryException::entityNotFoundWithSuchId(
                    $this->objectRepository->getClassName(),
                    (string) $id
                )
            )
            : Either::right($entity);
    }

    public function findAll(): Either
    {
        return ([] === $entities = $this->objectRepository->findAll())
            ? Either::left(
                MonadicRepositoryException::entityNotFound(
                    $this->objectRepository->getClassName()
                )
            )
            : Either::right($entities);
    }

    public function findBy(
        array $criteria,
        ?array $orderBy = null,
        ?int $limit = null,
        ?int $offset = null
    ): Either {
        return ([] === $entities = $this->objectRepository->findBy($criteria, $orderBy, $limit, $offset))
            ? Either::left(
                MonadicRepositoryException::entityNotFoundWithSuchCriteria(
                    $this->objectRepository->getClassName(),
                    $criteria
                )
            )
            : Either::right($entities);
    }

    public function findOneBy(
        array $criteria
    ): Either {
        return (null === $entity = $this->objectRepository->findOneBy($criteria))
            ? Either::left(
                MonadicRepositoryException::entityNotFoundWithSuchCriteria(
                    $this->objectRepository->getClassName(),
                    $criteria
                )
            )
            : Either::right($entity);
    }

    public function getClassName(): string
    {
        return $this->objectRepository->getClassName();
    }
}
