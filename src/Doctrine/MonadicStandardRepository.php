<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\RepositoryMonadicHelper\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use loophp\RepositoryMonadicHelper\Service\MonadicServiceRepositoryHelper;
use loophp\RepositoryMonadicHelper\Service\MonadicServiceRepositoryHelperInterface;
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
     * @var MonadicServiceRepositoryHelperInterface<L, R>
     */
    private MonadicServiceRepositoryHelperInterface $monadicServiceRepositoryHelper;

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
        $this->monadicServiceRepositoryHelper = new MonadicServiceRepositoryHelper();
    }

    public function find($id): Either
    {
        return $this
            ->monadicServiceRepositoryHelper
            ->eitherFind(
                $this->objectRepository,
                $id
            );
    }

    public function findAll(): Either
    {
        return $this
            ->monadicServiceRepositoryHelper
            ->eitherFindAll(
                $this->objectRepository,
            );
    }

    public function findBy(
        array $criteria,
        ?array $orderBy = null,
        ?int $limit = null,
        ?int $offset = null
    ): Either {
        return $this
            ->monadicServiceRepositoryHelper
            ->eitherFindBy(
                $this->objectRepository,
                $criteria,
                $orderBy,
                $limit,
                $offset
            );
    }

    public function findOneBy(
        array $criteria
    ): Either {
        return $this
            ->monadicServiceRepositoryHelper
            ->eitherFindOneBy(
                $this->objectRepository,
                $criteria
            );
    }

    public function getClassName(): string
    {
        return $this->objectRepository->getClassName();
    }
}
