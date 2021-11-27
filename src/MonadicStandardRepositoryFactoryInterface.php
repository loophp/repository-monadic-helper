<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\RepositoryMonadicHelper;

use Doctrine\Persistence\ObjectRepository;
use loophp\RepositoryMonadicHelper\Doctrine\MonadicStandardRepositoryInterface;
use Throwable;

interface MonadicStandardRepositoryFactoryInterface
{
    /**
     * @template R
     *
     * @param class-string<R> $entityClass
     *
     * @return MonadicStandardRepositoryInterface<Throwable, R>
     */
    public function fromEntity(string $entityClass): MonadicStandardRepositoryInterface;

    /**
     * @template R
     *
     * @param ObjectRepository<R> $objectRepository
     *
     * @return MonadicStandardRepositoryInterface<Throwable, R>
     */
    public function fromRepository(ObjectRepository $objectRepository): MonadicStandardRepositoryInterface;
}
