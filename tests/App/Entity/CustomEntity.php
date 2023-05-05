<?php

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
