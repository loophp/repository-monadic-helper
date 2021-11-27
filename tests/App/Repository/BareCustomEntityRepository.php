<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace tests\loophp\RepositoryMonadicHelper\App\Repository;

use Doctrine\Persistence\ObjectRepository;
use tests\loophp\RepositoryMonadicHelper\App\Entity\CustomEntity;

/**
 * @implements ObjectRepository<CustomEntity>
 */
class BareCustomEntityRepository implements ObjectRepository
{
    public function find($id)
    {
    }

    public function findAll()
    {
    }

    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null)
    {
    }

    public function findOneBy(array $criteria)
    {
    }

    public function getClassName()
    {
    }
}
