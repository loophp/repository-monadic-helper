<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\RepositoryMonadicHelper\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use loophp\RepositoryMonadicHelper\Service\MonadicServiceRepositoryHelper;
use Marcosh\LamPHPda\Either;

/**
 * @template L
 * @template R
 *
 * @implements MonadicServiceEntityRepositoryInterface<L, R>
 * @extends ServiceEntityRepository<R>
 */
class MonadicServiceEntityRepository extends ServiceEntityRepository implements MonadicServiceEntityRepositoryInterface
{
    public function eitherFind($id): Either
    {
        /** @var MonadicServiceRepositoryHelper<L, R> $helper */
        $helper = new MonadicServiceRepositoryHelper();

        return $helper->eitherFind($this, $id);
    }

    public function eitherFindAll(): Either
    {
        /** @var MonadicServiceRepositoryHelper<L, R> $helper */
        $helper = new MonadicServiceRepositoryHelper();

        return $helper->eitherFindAll($this);
    }

    public function eitherFindBy(
        array $criteria,
        ?array $orderBy = null,
        ?int $limit = null,
        ?int $offset = null
    ): Either {
        /** @var MonadicServiceRepositoryHelper<L, R> $helper */
        $helper = new MonadicServiceRepositoryHelper();

        return $helper->eitherFindBy($this, $criteria, $orderBy, $limit, $offset);
    }

    public function eitherFindOneBy(array $criteria): Either
    {
        /** @var MonadicServiceRepositoryHelper<L, R> $helper */
        $helper = new MonadicServiceRepositoryHelper();

        return $helper->eitherFindOneBy($this, $criteria);
    }
}
