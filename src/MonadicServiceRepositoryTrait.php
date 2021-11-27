<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\RepositoryMonadicHelper;

use Marcosh\LamPHPda\Either;

trait MonadicServiceRepositoryTrait
{
    public function eitherFind($id): Either
    {
        return (new MonadicServiceRepositoryHelper($this))->eitherFind($id);
    }

    public function eitherFindOneBy(array $criteria, ?array $orderBy = null): Either
    {
        return (new MonadicServiceRepositoryHelper($this))->eitherFindOneBy($criteria, $orderBy);
    }
}
