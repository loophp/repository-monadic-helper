<?php

declare(strict_types=1);

namespace loophp\RepositoryMonadicHelper;

use Doctrine\Persistence\ObjectRepository;
use loophp\RepositoryMonadicHelper\Doctrine\MonadicRepositoryInterface;
use loophp\RepositoryMonadicHelper\Exception\MonadicRepositoryExceptionInterface;

interface MonadicRepositoryFactoryInterface
{
    /**
     * @template R of object
     *
     * @param class-string<R> $entityClass
     *
     * @return MonadicRepositoryInterface<MonadicRepositoryExceptionInterface, R>
     */
    public function fromEntity(string $entityClass): MonadicRepositoryInterface;

    /**
     * @template R of object
     *
     * @param ObjectRepository<R> $objectRepository
     *
     * @return MonadicRepositoryInterface<MonadicRepositoryExceptionInterface, R>
     */
    public function fromRepository(ObjectRepository $objectRepository): MonadicRepositoryInterface;
}
