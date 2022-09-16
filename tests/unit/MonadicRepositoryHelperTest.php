<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

use Doctrine\Persistence\ObjectRepository;
use loophp\RepositoryMonadicHelper\Service\MonadicServiceRepositoryHelper;
use Marcosh\LamPHPda\Either;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use tests\loophp\RepositoryMonadicHelper\App\Entity\CustomEntity;

/**
 * @internal
 *
 * @coversNothing
 */
final class MonadicRepositoryHelperTest extends TestCase
{
    use ProphecyTrait;

    public function testEitherFind()
    {
        $helper = new MonadicServiceRepositoryHelper();
        $repository = $this->prophesize(ObjectRepository::class);

        $repository
            ->getClassName()
            ->willReturn('EntityClass');

        $repository
            ->find(123)
            ->willReturn(123);

        $return = $helper
            ->eitherFind($repository->reveal(), 123)
            ->eval(
                static fn (Throwable $i): Throwable => $i,
                static fn (int $i): int => $i
            );

        self::assertEquals(123, $return);

        $repository
            ->find('exception')
            ->willReturn(null);

        $return = $helper
            ->eitherFind($repository->reveal(), 'exception')
            ->eval(
                static fn (Throwable $i): Throwable => $i,
                static fn (int $i): int => $i
            );

        self::assertInstanceOf(Throwable::class, $return);
    }

    public function testEitherFindAll()
    {
        $helper = new MonadicServiceRepositoryHelper();
        $repository = $this->prophesize(ObjectRepository::class);

        $repository
            ->getClassName()
            ->willReturn('EntityClass');

        $repository
            ->findAll()
            ->willReturn([1, 2, 3]);

        $return = $helper
            ->eitherFindAll($repository->reveal())
            ->eval(
                static fn (Throwable $i): Throwable => $i,
                static fn (array $i): array => $i
            );

        self::assertEquals([1, 2, 3], $return);

        $repository
            ->findAll()
            ->willReturn([]);

        $return = $helper
            ->eitherFindAll($repository->reveal())
            ->eval(
                static fn (Throwable $i): Throwable => $i,
                static fn (array $i): array => $i
            );

        self::assertInstanceOf(Throwable::class, $return);
    }

    public function testEitherFindBy()
    {
        $helper = new MonadicServiceRepositoryHelper();
        $repository = $this->prophesize(ObjectRepository::class);

        $repository
            ->getClassName()
            ->willReturn('EntityClass');

        $repository
            ->findBy([], [], 1, 3)
            ->willReturn([1, 2, 3]);

        $return = $helper
            ->eitherFindBy($repository->reveal(), [], [], 1, 3)
            ->eval(
                static fn (Throwable $i): Throwable => $i,
                static fn (array $i): array => $i
            );

        self::assertEquals([1, 2, 3], $return);

        $repository
            ->findBy([], [], 1, 3)
            ->willReturn([]);

        $return = $helper
            ->eitherFindBy($repository->reveal(), [], [], 1, 3)
            ->eval(
                static fn (Throwable $i): Throwable => $i,
                static fn (array $i): array => $i
            );

        self::assertInstanceOf(Throwable::class, $return);
    }

    public function testEitherFindOneBy()
    {
        $helper = new MonadicServiceRepositoryHelper();
        $repository = $this->prophesize(ObjectRepository::class);

        $repository
            ->getClassName()
            ->willReturn('EntityClass');

        $repository
            ->findOneBy(['id' => 123])
            ->willReturn(123);

        $return = $helper
            ->eitherFindOneBy($repository->reveal(), ['id' => 123])
            ->eval(
                static fn (Throwable $i): Throwable => $i,
                static fn (int $i): int => $i
            );

        self::assertEquals(123, $return);

        $repository
            ->findOneBy(['id' => 'exception'])
            ->willReturn(null);

        $return = $helper
            ->eitherFindOneBy($repository->reveal(), ['id' => 'exception'])
            ->eval(
                static fn (Throwable $i): Throwable => $i,
                static fn (array $i): array => $i
            );

        self::assertInstanceOf(Throwable::class, $return);
    }

    public function testUsage()
    {
        $helper = new MonadicServiceRepositoryHelper();
        $repository = $this->prophesize(ObjectRepository::class);
        $entity = $this->prophesize(CustomEntity::class);

        $repository
            ->getClassName()
            ->willReturn('EntityClass');

        // Testcase 1
        $entity
            ->getTitle()
            ->willReturn('title');

        $repository
            ->find(1)
            ->willReturn($entity->reveal());

        $return = $helper
            ->eitherFind($repository->reveal(), 1)
            ->bind(
                static function (CustomEntity $customEntity): Either {
                    return (null === $customEntity->getTitle())
                        ? Either::left(
                            new Exception('Empty title')
                        )
                        : Either::right($customEntity);
                }
            )
            ->map(
                static function (CustomEntity $customEntity): string {
                    return sprintf('%s%s', $customEntity->getTitle(), $customEntity->getTitle());
                }
            )
            ->eval(
                static fn (Throwable $i): Throwable => $i,
                static fn (string $titles): string => $titles
            );

        self::assertEquals('titletitle', $return);

        // Testcase 2
        $repository
            ->find(2)
            ->willReturn(null);

        $return = $helper
            ->eitherFind($repository->reveal(), 2)
            ->bind(
                static function (CustomEntity $customEntity): Either {
                    return (null === $customEntity->getTitle())
                        ? Either::left(
                            new Exception('Empty title')
                        )
                        : Either::right($customEntity);
                }
            )
            ->map(
                static function (CustomEntity $customEntity): string {
                    return sprintf('%s%s', $customEntity->getTitle(), $customEntity->getTitle());
                }
            )
            ->eval(
                static fn (Throwable $i): string => $i->getMessage(),
                static fn (string $titles): string => $titles
            );

        self::assertEquals('Unable to find an entity (EntityClass) with such ID (2).', $return);

        // Testcase 3
        $entity
            ->getTitle()
            ->willReturn('');

        $repository
            ->find(3)
            ->willReturn($entity->reveal());

        $return = $helper
            ->eitherFind($repository->reveal(), 3)
            ->bind(
                static function (CustomEntity $customEntity): Either {
                    return ('' === $customEntity->getTitle())
                    ? Either::left(new Exception('Empty title'))
                    : Either::right($customEntity);
                }
            )
            ->map(
                static function (CustomEntity $customEntity): string {
                    return sprintf('%s%s', $customEntity->getTitle(), $customEntity->getTitle());
                }
            )
            ->eval(
                static fn (Throwable $i): string => $i->getMessage(),
                static fn (string $titles): string => $titles
            );

        self::assertEquals('Empty title', $return);
    }
}
