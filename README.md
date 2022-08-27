[![Latest Stable Version][latest stable version]][1]
[![GitHub stars][github stars]][1]
[![Total Downloads][total downloads]][1]
[![Type Coverage][type coverage]][4]
[![License][license]][1]
[![Donate!][donate github]][github sponsors link]

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

The monad in use in this project is the _Either_ monad, provided
by the contrib package [Lamphpda][51] from [Marco Perone][52].

## History

This project started as a proof-of-concept for my own needs and for many
reasons.

I first wanted to get rid of all the checks and conditions that were
needed in my code to test if an entity was existing or not.

Then, it turns out that this was a recurrent pattern that I was seeing the code
of my friends, colleagues and [issue queue][55].

A practical way to get rid of conditions is to use a more declarative way
of programming and adopt a more functional programming style.

And lastly, willing to learn more about the monads which are some kind of
"design patterns" for functional programming, I started to write this package.

This package does not have the pretention to become a _de-facto_ standard on how
to use Doctrine repositories, but it might help people understanding what monads
are, how to use them, and hopefully reduce the amount of conditions in their
code.

The monad package in use here is an arbitrary choice. I could have used
some other packages, but [marcosh/lamphpda][51] seems to be the best option,
especially when you analyse your code with static analysis tools to detect
issues upfront, without running their unit tests.

## Installation

```shell
composer require loophp/repository-monadic-helper
```

## Usage

To use this package and have monadic repositories, there are
3 options available:

- Without alteration of existing Doctrine repositories
  - **Options 1**: By using a service which is
    creating a monadic repository from an entity class
    name or an existing repository.
- With alteration of existing Doctrine repositories
  - **Option 2**: By adding an interface, a trait and relevant
    typing information like:
    `@implements MonadicServiceEntityRepositoryInterface<EntityClassName>`
  - **Option 3**: By replacing `extends ServiceEntityRepository`
    with `extends MonadicServiceEntityRepository`
    and add relevant typing information like:
    `@extends MonadicServiceEntityRepository<EntityClassName>`

In my own opinion, the best way to use this package is to
**use the first option**.

It's paramount to replace `EntityClassName` with the entity class in use in the
repository in order to let static analysis tools infer types properly.

For the option 2 and 3, let's use the following usual Doctrine repository as
example:

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

### Option 1: Using a service

```php
<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\MyCustomEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use loophp\RepositoryMonadicHelper\MonadicRepositoryFactoryInterface;
use Throwable;

final class MyCustomController
{
    public function __invoke(
        MonadicRepositoryFactoryInterface $monadicRepositoryFactory
    ) {
        $body = $monadicRepositoryFactory
            ->fromEntity(MyCustomEntity::class)
            ->eitherFind(123) // This returns a Either monad.
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

### Option 2: Using an interface and a trait on existing repositories

Upgrade your Doctrine repositories to:

```php
<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\MyCustomEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use loophp\RepositoryMonadicHelper\Doctrine\MonadicServiceEntityRepositoryInterface;
use loophp\RepositoryMonadicHelper\MonadicServiceEntityRepositoryTrait;
use Throwable;

/**
 * @implements MonadicServiceEntityRepositoryInterface<Throwable, MyCustomEntity>
 */
class MyCustomEntityRepository extends ServiceEntityRepository implements MonadicServiceEntityRepositoryInterface
{
    Use MonadicServiceEntityRepositoryTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MyCustomEntity::class);
    }
}
```

### Option 3: Replace `ServiceEntityRepository` with `MonadicServiceEntityRepository`

Upgrade your Doctrine repositories to:

```php
<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\MyCustomEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use loophp\RepositoryMonadicHelper\MonadicServiceEntityRepository;

/**
 * @extends MonadicServiceEntityRepository<MyCustomEntity>
 */
class MyCustomEntityRepository extends MonadicServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MyCustomEntity::class);
    }
}
```

## API

The following methods will be available when using the service (option 1) or
upgrading your repositories (options 2 and 3).

For each API methods, the placeholder `MyCustomEntity` should be replaced by
the entity you're referring to.

### eitherFind

Signature:

```php
eitherFind(int|string $id): Either<Throwable, MyCustomEntity>
```

An exception is generated and wrapped in the monad when the returned result is
`null`.

### eitherFindAll

Signature:

```php
eitherFindAll(): Either<Throwable, list<MyCustomEntity>>
```

An exception is generated and wrapped in the monad when the returned result is
empty.

### eitherFindBy

Signature:

```php
eitherFindBy(array $criteria, ?array $orderBy = null, ?int $limit = null, ?int $offset = null): Either<Throwable, list<MyCustomEntity>>
```

An exception is generated and wrapped in the monad when the returned result is
empty.

### eitherFindOneBy

Signature:

```php
eitherFindOneBy(array $criteria): Either<Throwable, MyCustomEntity>
```

An exception is generated and wrapped in the monad when the returned result is
`null`.

## Todo

- Improve documentation and code examples.

## Contributing

Feel free to contribute by sending pull requests. We are a usually very
responsive team and we will help you going through your pull request from the
beginning to the end.

For some reasons, if you can't contribute to the code and willing to help,
sponsoring is a good, sound and safe way to show us some gratitude for the hours
we invested in this package.

Sponsor me on [Github][github sponsors link] and/or any of [the
contributors][contributors].

## Changelog

See [CHANGELOG.md][47] for a changelog based on [git commits][46].

For more detailed changelogs, please check [the release changelogs][45].

[1]: https://packagist.org/packages/loophp/repository-monadic-helper
[latest stable version]: https://img.shields.io/packagist/v/loophp/repository-monadic-helper.svg?style=flat-square
[github stars]: https://img.shields.io/github/stars/loophp/repository-monadic-helper.svg?style=flat-square
[total downloads]: https://img.shields.io/packagist/dt/loophp/repository-monadic-helper.svg?style=flat-square
[license]: https://img.shields.io/packagist/l/loophp/repository-monadic-helper.svg?style=flat-square
[donate github]: https://img.shields.io/badge/Sponsor-Github-brightgreen.svg?style=flat-square
[type coverage]: https://img.shields.io/badge/dynamic/json?style=flat-square&color=color&label=Type%20coverage&query=message&url=https%3A%2F%2Fshepherd.dev%2Fgithub%2Floophp%2Frepository-monadic-helper%2Fcoverage
[4]: https://shepherd.dev/github/loophp/repository-monadic-helper
[34]: https://github.com/loophp/repository-monadic-helper/issues
[2]: https://github.com/loophp/repository-monadic-helper/actions
[35]: http://www.phpspec.net/
[36]: https://github.com/phpro/grumphp
[37]: https://github.com/infection/infection
[38]: https://github.com/phpstan/phpstan
[39]: https://github.com/vimeo/psalm
[github sponsors link]: https://github.com/sponsors/drupol
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
[54]: https://github.com/phpstan/phpstan/issues/6143
[55]: https://github.com/doctrine/persistence/issues/23
[contributors]: https://github.com/loophp/repository-monadic-helper/graphs/contributors