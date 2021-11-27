<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\RepositoryMonadicHelper\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use loophp\RepositoryMonadicHelper\Service\MonadicServiceRepositoryHelper;
use loophp\RepositoryMonadicHelper\Service\MonadicServiceRepositoryHelperInterface;
use Marcosh\LamPHPda\Either;
use Throwable;

/**
 * @template R
 *
 * @implements MonadicServiceEntityRepositoryInterface<Throwable, R>
 * @extends ServiceEntityRepository<R>
 */
class MonadicServiceEntityRepository extends ServiceEntityRepository implements MonadicServiceEntityRepositoryInterface
{
    public function eitherFind($id): Either
    {
        return $this->getMonadicServiceRepositoryHelper()->eitherFind($this, $id);
    }

    public function eitherFindAll(): Either
    {
        return $this->getMonadicServiceRepositoryHelper()->eitherFindAll($this);
    }

    public function eitherFindBy(
        array $criteria,
        ?array $orderBy = null,
        ?int $limit = null,
        ?int $offset = null
    ): Either {
        return $this->getMonadicServiceRepositoryHelper()->eitherFindBy($this, $criteria, $orderBy, $limit, $offset);
    }

    public function eitherFindOneBy(array $criteria): Either
    {
        return $this->getMonadicServiceRepositoryHelper()->eitherFindOneBy($this, $criteria);
    }

    /**
     * @return MonadicServiceRepositoryHelperInterface<Throwable, R>
     */
    private function getMonadicServiceRepositoryHelper(): MonadicServiceRepositoryHelperInterface
    {
        return new MonadicServiceRepositoryHelper();
    }
}
