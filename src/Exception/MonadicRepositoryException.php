<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\RepositoryMonadicHelper\Exception;

use Exception;
use Throwable;

final class MonadicRepositoryException extends Exception
{
    public static function entityNotFoundWithSuchCriteria(
        array $criteria,
        int $code = 0,
        ?Throwable $previous = null
    ): self {
        // TODO: What do we do with $criteria ?
        return new self(
            'Unable to find an entity with such criteria.',
            $code,
            $previous
        );
    }

    public static function entityNotFoundWithSuchId(string $id, int $code = 0, ?Throwable $previous = null): self
    {
        return new self(
            sprintf('Unable to find an entity with such ID (%s).', $id),
            $code,
            $previous
        );
    }
}
