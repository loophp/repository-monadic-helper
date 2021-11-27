[![Latest Stable Version][latest stable version]][1]
 [![GitHub stars][github stars]][1]
 [![Total Downloads][total downloads]][1]
 [![License][license]][1]
 [![Donate!][donate github]][5]
 [![Donate!][donate paypal]][6]

# Doctrine Repository Monadic Helper

## Description

TODO

## Installation

```shell
composer require loophp/repository-monadic-helper
```

## Usage

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
use loophp\RepositoryMonadicHelper\{MonadicServiceRepositoryInterface, MonadicServiceRepositoryTrait};
use Throwable;

/**
 * @implements MonadicServiceRepositoryInterface<Throwable, MasAccountCodes>
 */
class MyCustomEntityRepository extends ServiceEntityRepository implements MonadicServiceRepositoryInterface
{
    use MonadicServiceRepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MyCustomEntity::class);
    }
}

```

## Contributing

Feel free to contribute by sending Github pull requests. I'm quite responsive :-)

If you can't contribute to the code, you can also sponsor me on [Github][5] or
[Paypal][6].

## Changelog

See [CHANGELOG.md][47] for a changelog based on [git commits][46].

For more detailed changelogs, please check [the release changelogs][45].

[1]: https://packagist.org/packages/loophp/repository-monadic-helper
[latest stable version]: https://img.shields.io/packagist/v/loophp/repository-monadic-helper.svg?style=flat-square
[github stars]: https://img.shields.io/github/stars/loophp/repository-monadic-helper.svg?style=flat-square
[total downloads]: https://img.shields.io/packagist/dt/loophp/repository-monadic-helper.svg?style=flat-square
[license]: https://img.shields.io/packagist/l/loophp/repository-monadic-helper.svg?style=flat-square
[donate github]: https://img.shields.io/badge/Sponsor-Github-brightgreen.svg?style=flat-square
[donate paypal]: https://img.shields.io/badge/Sponsor-Paypal-brightgreen.svg?style=flat-square
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