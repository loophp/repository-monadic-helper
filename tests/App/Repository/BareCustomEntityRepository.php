<?php

declare(strict_types=1);

namespace tests\loophp\RepositoryMonadicHelper\App\Repository;

use Doctrine\Persistence\ObjectRepository;
use tests\loophp\RepositoryMonadicHelper\App\Entity\CustomEntity;

/**
 * @implements ObjectRepository<CustomEntity>
 */
class BareCustomEntityRepository implements ObjectRepository
{
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
