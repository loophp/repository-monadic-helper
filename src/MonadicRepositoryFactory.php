<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\RepositoryMonadicHelper;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use loophp\RepositoryMonadicHelper\Doctrine\MonadicRepository;
use loophp\RepositoryMonadicHelper\Doctrine\MonadicRepositoryInterface;

final class MonadicRepositoryFactory implements MonadicRepositoryFactoryInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function fromEntity(string $entityClass): MonadicRepositoryInterface
    {
        return new MonadicRepository($this->entityManager, $entityClass);
    }

    public function fromRepository(ObjectRepository $objectRepository): MonadicRepositoryInterface
    {
        return $this->fromEntity($objectRepository->getClassName());
    }
}
