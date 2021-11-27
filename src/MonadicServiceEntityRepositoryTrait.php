<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\RepositoryMonadicHelper;

use loophp\RepositoryMonadicHelper\Service\MonadicServiceRepositoryHelper;
use Marcosh\LamPHPda\Either;

trait MonadicServiceEntityRepositoryTrait
{
    public function eitherFind($id): Either
    {
        return (new MonadicServiceRepositoryHelper())->eitherFind($this, $id);
    }

    public function eitherFindAll(): Either
    {
        return (new MonadicServiceRepositoryHelper())->eitherFindAll($this);
    }

    public function eitherFindBy(
        array $criteria,
        ?array $orderBy = null,
        ?int $limit = null,
        ?int $offset = null
    ): Either {
        return (new MonadicServiceRepositoryHelper())->eitherFindBy($this, $criteria, $orderBy, $limit, $offset);
    }

    public function eitherFindOneBy(array $criteria): Either
    {
        return (new MonadicServiceRepositoryHelper())->eitherFindOneBy($this, $criteria);
    }
}
