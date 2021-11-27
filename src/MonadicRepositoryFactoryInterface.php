<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\RepositoryMonadicHelper;

use Doctrine\Persistence\ObjectRepository;
use loophp\RepositoryMonadicHelper\Doctrine\MonadicRepositoryInterface;
use Throwable;

interface MonadicRepositoryFactoryInterface
{
    /**
     * @template R
     *
     * @param class-string<R> $entityClass
     *
     * @return MonadicRepositoryInterface<Throwable, R>
     */
    public function fromEntity(string $entityClass): MonadicRepositoryInterface;

    /**
     * @template R
     *
     * @param ObjectRepository<R> $objectRepository
     *
     * @return MonadicRepositoryInterface<Throwable, R>
     */
    public function fromRepository(ObjectRepository $objectRepository): MonadicRepositoryInterface;
}
