<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\RepositoryMonadicHelper\Exception;

use Throwable;

interface MonadicRepositoryExceptionInterface extends Throwable
{
    public static function entityNotFound(
        string $entityClass,
        int $code = 0,
        ?Throwable $previous = null
    ): self;

    /**
     * @param array<string, mixed> $criteria
     */
    public static function entityNotFoundWithSuchCriteria(
        string $entityClass,
        array $criteria,
        int $code = 0,
        ?Throwable $previous = null
    ): self;

    public static function entityNotFoundWithSuchId(
        string $entityClass,
        string $id,
        int $code = 0,
        ?Throwable $previous = null
    ): self;
}
