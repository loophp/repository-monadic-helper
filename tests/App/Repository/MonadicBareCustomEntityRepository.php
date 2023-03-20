<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace tests\loophp\RepositoryMonadicHelper\App\Repository;

use loophp\RepositoryMonadicHelper\Doctrine\MonadicServiceEntityRepositoryInterface;
use loophp\RepositoryMonadicHelper\MonadicServiceEntityRepositoryTrait;
use tests\loophp\RepositoryMonadicHelper\App\Entity\CustomEntity;
use Throwable;

/**
 * @implements MonadicServiceEntityRepositoryInterface<Throwable, CustomEntity>
 */
class MonadicBareCustomEntityRepository implements MonadicServiceEntityRepositoryInterface
{
    use MonadicServiceEntityRepositoryTrait;

    public function find($id): ?CustomEntity
    {
        if (random_int(0, 1)) {
            return null;
        }

        return new CustomEntity();
    }

    /**
     * @return CustomEntity[]
     */
    public function findAll(): array
    {
        return [new CustomEntity()];
    }

    public function findBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): array
    {
        if (random_int(0, 1)) {
            return [];
        }

        return [new CustomEntity()];
    }

    public function findOneBy(array $criteria): ?CustomEntity
    {
        if (random_int(0, 1)) {
            return null;
        }

        return new CustomEntity();
    }

    public function getClassName()
    {
        return CustomEntity::class;
    }
}
