<?php

declare(strict_types=1);

namespace loophp\RepositoryMonadicHelper\Exception;

use Exception;
use Throwable;

final class MonadicRepositoryException extends Exception implements MonadicRepositoryExceptionInterface
{
    public static function entityNotFound(
        string $entityClass,
        int $code = 0,
        ?Throwable $previous = null
    ): self {
        return new self(
            sprintf('Unable to find any entity (%s).', $entityClass),
            $code,
            $previous
        );
    }

    /**
     * @param array<string, mixed> $criteria
     */
    public static function entityNotFoundWithSuchCriteria(
        string $entityClass,
        array $criteria,
        int $code = 0,
        ?Throwable $previous = null
    ): self {
        // TODO: What do we do with $criteria ?
        return new self(
            sprintf('Unable to find an entity (%s) with such criteria.', $entityClass),
            $code,
            $previous
        );
    }

    public static function entityNotFoundWithSuchId(
        string $entityClass,
        string $id,
        int $code = 0,
        ?Throwable $previous = null
    ): self {
        return new self(
            sprintf('Unable to find an entity (%s) with such ID (%s).', $entityClass, $id),
            $code,
            $previous
        );
    }
}
