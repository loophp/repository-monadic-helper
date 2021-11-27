<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\RepositoryMonadicHelper;

use Doctrine\Persistence\ObjectRepository;
use loophp\RepositoryMonadicHelper\Exception\MonadicRepositoryException;
use Marcosh\LamPHPda\Either;
use Throwable;

/**
 * @template L of Throwable
 * @template R of object
 */
final class MonadicServiceRepositoryHelper implements MonadicServiceRepositoryInterface
{
    /**
     * @var ObjectRepository<R>
     */
    private ObjectRepository $objectRepository;

    /**
     * @param ObjectRepository<R> $objectRepository
     */
    public function __construct(ObjectRepository $objectRepository)
    {
        $this->objectRepository = $objectRepository;
    }

    public function eitherFind($id): Either
    {
        return (null === $entity = $this->objectRepository->find($id)) ?
            Either::left(MonadicRepositoryException::entityNotFoundWithSuchId((string) $id)) :
            Either::right($entity);
    }

    public function eitherFindOneBy(array $criteria, ?array $orderBy = null): Either
    {
        return (null === $entity = $this->objectRepository->findOneBy($criteria, $orderBy)) ?
            Either::left(MonadicRepositoryException::entityNotFoundWithSuchCriteria($criteria)) :
            Either::right($entity);
    }

    public function find($id)
    {
        return $this->objectRepository->find($id);
    }

    public function findAll()
    {
        return $this->objectRepository->findAll();
    }

    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->objectRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    public function findOneBy(array $criteria)
    {
        return $this->objectRepository->findOneBy($criteria);
    }
}
