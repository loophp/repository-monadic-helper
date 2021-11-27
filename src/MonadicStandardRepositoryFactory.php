<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\RepositoryMonadicHelper;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use loophp\RepositoryMonadicHelper\Doctrine\MonadicStandardRepository;
use loophp\RepositoryMonadicHelper\Doctrine\MonadicStandardRepositoryInterface;

final class MonadicStandardRepositoryFactory implements MonadicStandardRepositoryFactoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function fromEntity(string $entityClass): MonadicStandardRepositoryInterface
    {
        return new MonadicStandardRepository($this->entityManager, $entityClass);
    }

    public function fromRepository(ObjectRepository $objectRepository): MonadicStandardRepositoryInterface
    {
        return $this->fromEntity($this->getEntityClass($objectRepository));
    }

    /**
     * @template R
     *
     * @param ObjectRepository<R> $objectRepository
     *
     * @return class-string<R>
     *
     * @see https://github.com/doctrine/persistence/pull/213
     */
    private function getEntityClass(ObjectRepository $objectRepository): string
    {
        return $objectRepository->getClassName();
    }
}
