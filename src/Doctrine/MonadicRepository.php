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
use Throwable;

/**
 * @template R of object
 *
 * @implements MonadicRepositoryInterface<Throwable, R>
 */
final class MonadicRepository implements MonadicRepositoryInterface
{
    /**
     * @var MonadicServiceRepositoryHelperInterface<Throwable, R>
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

        /** @var MonadicServiceRepositoryHelperInterface<Throwable, R> $monadicServiceRepositoryHelper */
        $monadicServiceRepositoryHelper = new MonadicServiceRepositoryHelper();

        $this->monadicServiceRepositoryHelper = $monadicServiceRepositoryHelper;
    }

    public function eitherFind($id): Either
    {
        return $this
            ->monadicServiceRepositoryHelper
            ->eitherFind($this->objectRepository, $id);
    }

    public function eitherFindAll(): Either
    {
        return $this
            ->monadicServiceRepositoryHelper
            ->eitherFindAll($this->objectRepository);
    }

    public function eitherFindBy(
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

    public function eitherFindOneBy(array $criteria): Either
    {
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
