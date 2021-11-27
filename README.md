[![Latest Stable Version][latest stable version]][1]
 [![GitHub stars][github stars]][1]
 [![Total Downloads][total downloads]][1]
 [![License][license]][1]
 [![Donate!][donate github]][5]

# Doctrine Repository Monadic Helper

## Description

This project provides the necessary classes and services
to use Doctrine repositories in a more functional way, by using monads.

This project also demonstrate that it's a nice and clean
way to work with repositories and non-deterministic data store, in this
case, a database.

There is no need to always check for the existence of an entity, so we
are able to reduce the amount of conditions and cruft, while focusing on
what's important and relevant only.

When using properly typed monads and callbacks, types inconsistencies will
be instantly detected by static analysis tools. This provides a safer and
better way to design functions and data transformation methods.

The monad in use in this project is the *Either* monad, provided
by the contrib package [Lamphpda][51] from [Marco Perone][52].

## Installation

```shell
composer require loophp/repository-monadic-helper
```

## Usage

### By using a dedicated service

```php
<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\MyCustomEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Throwable;

final class MyCustomController
{
    public function __invoke(
        MonadicStandardRepositoryFactoryInterface $monadicStandardRepositoryFactory
    ) {
        $body = $monadicStandardRepositoryFactory
            ->fromEntity(MyCustomEntity::class);
            ->find(123) // This returns a Either monad.
            ->map(
                static fn (MyCustomEntity $entity): string => $entity->getTitle()
            )
            ->eval(
                static fn (Throwable $exception): string => $exception->getMessage(),
                static fn (string $entity): string => $entity
            );

        return new Response($body);
    }
}
```

### By altering existing Doctrine repositories

Upgrade your Doctrine repositories from:

```php
<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\MyCustomEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MyCustomEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method MyCustomEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method MyCustomEntity[]    findAll()
 * @method MyCustomEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MyCustomEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MyCustomEntity::class);
    }
}
```

To:

```php
<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\MyCustomEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use loophp\RepositoryMonadicHelper\MonadicServiceEntityRepository;
use Throwable;

/**
 * @implements MonadicServiceEntityRepository<Throwable, MyCustomEntity>
 */
class MyCustomEntityRepository extends MonadicServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MyCustomEntity::class);
    }
}
```

Update the way you're using Repositories from:

```php
<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\MyCustomEntity;
use App\Repository\MyCustomEntityRepository;
use Symfony\Component\HttpFoundation\Response;

final class MyCustomController
{
    public function __invoke(MyCustomEntityRepository $myCustomEntityRepository): Response
    {
        $id = /* Whatever value */;

        /** @var null|MyCustomEntity $myCustomEntity */
        $myCustomEntity = $myCustomEntityRepository->find($id);

        if ($myCustomEntity === null) {
            return new Response('No entity found with such ID.'),
        }

        return new Response(sprintf('Entity ID found, title: %s', $myCustomEntity->getTitle()))
    }
}
```

To:

```php
<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\MyCustomEntity;
use App\Repository\MyCustomEntityRepository;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class MyCustomController
{
    public function __invoke(MyCustomEntityRepository $myCustomEntityRepository): Response
    {
        $id = /* Whatever value */;

        $responseBody = $myCustomEntityRepository
            ->eitherFind($id)
            ->eval(
                fn (Throwable $exception): string => $exception->getMessage(),
                fn (MyCustomEntity $myCustomEntity): string =>
                    sprintf('Entity ID found, title: %s', $myCustomEntity->getTitle())
            );

        return new Response($responseBody);
    }
}
```

## Todo

* Finding root cause of Psalm issues and get rid of the baseline file,
* Get rid of PHPStan baseline as soon as this [PR][53] is released,
* Improve documentation and code examples.

## Contributing

Feel free to contribute by sending Github pull requests. I'm quite responsive :-)

If you can't contribute to the code, you can also sponsor me on [Github][5].

## Changelog

See [CHANGELOG.md][47] for a changelog based on [git commits][46].

For more detailed changelogs, please check [the release changelogs][45].

[1]: https://packagist.org/packages/loophp/repository-monadic-helper
[latest stable version]: https://img.shields.io/packagist/v/loophp/repository-monadic-helper.svg?style=flat-square
[github stars]: https://img.shields.io/github/stars/loophp/repository-monadic-helper.svg?style=flat-square
[total downloads]: https://img.shields.io/packagist/dt/loophp/repository-monadic-helper.svg?style=flat-square
[license]: https://img.shields.io/packagist/l/loophp/repository-monadic-helper.svg?style=flat-square
[donate github]: https://img.shields.io/badge/Sponsor-Github-brightgreen.svg?style=flat-square
[34]: https://github.com/loophp/repository-monadic-helper/issues
[2]: https://github.com/loophp/repository-monadic-helper/actions
[35]: http://www.phpspec.net/
[36]: https://github.com/phpro/grumphp
[37]: https://github.com/infection/infection
[38]: https://github.com/phpstan/phpstan
[39]: https://github.com/vimeo/psalm
[5]: https://github.com/sponsors/drupol
[6]: https://www.paypal.me/drupol
[40]: https://packagist.org/packages/doctrine/doctrine-bundle
[41]: https://en.wikipedia.org/wiki/SOLID
[42]: https://en.wikipedia.org/wiki/Open%E2%80%93closed_principle
[43]: https://github.com/symfony/maker-bundle/pull/887
[44]: https://tomasvotruba.com/blog/2017/10/16/how-to-use-repository-with-doctrine-as-service-in-symfony/
[45]: https://github.com/loophp/repository-monadic-helper/releases
[46]: https://github.com/loophp/repository-monadic-helper/commits/master
[47]: https://github.com/loophp/repository-monadic-helper/blob/master/CHANGELOG.md
[48]: https://packagist.org/packages/symfony/maker-bundle
[49]: https://packagist.org/packages/doctrine/persistence
[50]: https://symfony.com/doc/current/service_container.html#binding-arguments-by-name-or-type
[51]: https://github.com/marcosh/lamphpda
[52]: https://github.com/marcosh/
[53]: https://github.com/doctrine/persistence/pull/213