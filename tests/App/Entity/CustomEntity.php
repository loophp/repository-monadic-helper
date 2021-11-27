<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace tests\loophp\RepositoryMonadicHelper\App\Entity;

class CustomEntity
{
    public string $title = '';

    public function getTitle(): string
    {
        return $this->title;
    }
}
