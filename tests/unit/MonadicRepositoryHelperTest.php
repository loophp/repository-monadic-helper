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
use tests\loophp\RepositoryMonadicHelper\App\Entity\CustomEntity;

/**
 * @internal
 *
 * @coversNothing
 */
final class MonadicRepositoryHelperTest extends TestCase
{
    public function testEitherFind()
    {
        $helper = new MonadicServiceRepositoryHelper();
        $repository = $this
            ->getMockBuilder(ObjectRepository::class)
            ->getMock();

        $repository
            ->method('getClassName')
            ->willReturn('EntityClass');

        $repository
            ->method('find')
            ->willReturn(123);

        $return = $helper
            ->eitherFind($repository, 123)
            ->eval(
                static fn (Throwable $i): Throwable => $i,
                static fn (int $i): int => $i
            );

        self::assertEquals(123, $return);

        $repository = $this
            ->getMockBuilder(ObjectRepository::class)
            ->getMock();

        $repository
            ->method('getClassName')
            ->willReturn('EntityClass');

        $repository
            ->method('find')
            ->willReturn(null);

        $return = $helper
            ->eitherFind($repository, 'exception')
            ->eval(
                static fn (Throwable $i): Throwable => $i,
                static fn (int $i): int => $i
            );

        self::assertInstanceOf(Throwable::class, $return);
    }

    public function testEitherFindAll()
    {
        $helper = new MonadicServiceRepositoryHelper();

        $repository = $this
            ->getMockBuilder(ObjectRepository::class)
            ->getMock();

        $repository
            ->method('getClassName')
            ->willReturn('EntityClass');

        $repository
            ->method('findAll')
            ->willReturn([1, 2, 3]);

        $return = $helper
            ->eitherFindAll($repository)
            ->eval(
                static fn (Throwable $i): Throwable => $i,
                static fn (array $i): array => $i
            );

        self::assertEquals([1, 2, 3], $return);

        $repository = $this
            ->getMockBuilder(ObjectRepository::class)
            ->getMock();

        $repository
            ->method('getClassName')
            ->willReturn('EntityClass');

        $repository
            ->method('findAll')
            ->willReturn([]);

        $return = $helper
            ->eitherFindAll($repository)
            ->eval(
                static fn (Throwable $i): Throwable => $i,
                static fn (array $i): array => $i
            );

        self::assertInstanceOf(Throwable::class, $return);
    }

    public function testEitherFindBy()
    {
        $helper = new MonadicServiceRepositoryHelper();
        $repository = $this
            ->getMockBuilder(ObjectRepository::class)
            ->getMock();

        $repository
            ->method('getClassName')
            ->willReturn('EntityClass');

        $repository
            ->method('findBy')
            ->willReturn([1, 2, 3]);

        $return = $helper
            ->eitherFindBy($repository, [], [], 1, 3)
            ->eval(
                static fn (Throwable $i): Throwable => $i,
                static fn (array $i): array => $i
            );

        self::assertEquals([1, 2, 3], $return);

        $repository = $this
            ->getMockBuilder(ObjectRepository::class)
            ->getMock();

        $repository
            ->method('getClassName')
            ->willReturn('EntityClass');

        $repository
            ->method('findBy')
            ->willReturn([]);

        $return = $helper
            ->eitherFindBy($repository, [], [], 1, 3)
            ->eval(
                static fn (Throwable $i): Throwable => $i,
                static fn (array $i): array => $i
            );

        self::assertInstanceOf(Throwable::class, $return);
    }

    public function testEitherFindOneBy()
    {
        $helper = new MonadicServiceRepositoryHelper();
        $repository = $this
            ->getMockBuilder(ObjectRepository::class)
            ->getMock();

        $repository
            ->method('getClassName')
            ->willReturn('EntityClass');

        $repository
            ->method('findOneBy')
            ->willReturn(123);

        $return = $helper
            ->eitherFindOneBy($repository, ['id' => 123])
            ->eval(
                static fn (Throwable $i): Throwable => $i,
                static fn (int $i): int => $i
            );

        self::assertEquals(123, $return);

        $repository = $this
            ->getMockBuilder(ObjectRepository::class)
            ->getMock();

        $repository
            ->method('getClassName')
            ->willReturn('EntityClass');

        $repository
            ->method('findOneBy')
            ->willReturn(null);

        $return = $helper
            ->eitherFindOneBy($repository, ['id' => 'exception'])
            ->eval(
                static fn (Throwable $i): Throwable => $i,
                static fn (array $i): array => $i
            );

        self::assertInstanceOf(Throwable::class, $return);
    }

    public function testUsage()
    {
        $helper = new MonadicServiceRepositoryHelper();
        $repository = $this
            ->getMockBuilder(ObjectRepository::class)
            ->getMock();

        $repository
            ->method('getClassName')
            ->willReturn('EntityClass');

        $entity = $this
            ->getMockBuilder(CustomEntity::class)
            ->getMock();

        // Testcase 1
        $entity
            ->method('getTitle')
            ->willReturn('title');

        $repository
            ->method('find')
            ->willReturn($entity);

        $return = $helper
            ->eitherFind($repository, 1)
            ->bind(
                static fn (CustomEntity $customEntity): Either => (null === $customEntity->getTitle())
                    ? Either::left(
                        new Exception('Empty title')
                    )
                    : Either::right($customEntity)
            )
            ->map(
                static fn (CustomEntity $customEntity): string => sprintf('%s%s', $customEntity->getTitle(), $customEntity->getTitle())
            )
            ->eval(
                static fn (Throwable $i): Throwable => $i,
                static fn (string $titles): string => $titles
            );

        self::assertEquals('titletitle', $return);

        // Testcase 2

        $repository = $this
            ->getMockBuilder(ObjectRepository::class)
            ->getMock();

        $repository
            ->method('getClassName')
            ->willReturn('EntityClass');

        $repository
            ->method('find')
            ->willReturn(null);

        $return = $helper
            ->eitherFind($repository, 2)
            ->bind(
                static fn (CustomEntity $customEntity): Either => (null === $customEntity->getTitle())
                    ? Either::left(
                        new Exception('Empty title')
                    )
                    : Either::right($customEntity)
            )
            ->map(
                static fn (CustomEntity $customEntity): string => sprintf('%s%s', $customEntity->getTitle(), $customEntity->getTitle())
            )
            ->eval(
                static fn (Throwable $i): string => $i->getMessage(),
                static fn (string $titles): string => $titles
            );

        self::assertEquals('Unable to find an entity (EntityClass) with such ID (2).', $return);

        // Testcase 3
        $repository = $this
            ->getMockBuilder(ObjectRepository::class)
            ->getMock();

        $repository
            ->method('getClassName')
            ->willReturn('EntityClass');

        $entity = $this
            ->getMockBuilder(CustomEntity::class)
            ->getMock();

        $entity
            ->method('getTitle')
            ->willReturn('');

        $repository
            ->method('find')
            ->willReturn($entity);

        $return = $helper
            ->eitherFind($repository, 3)
            ->bind(
                static fn (CustomEntity $customEntity): Either => ('' === $customEntity->getTitle())
                ? Either::left(new Exception('Empty title'))
                : Either::right($customEntity)
            )
            ->map(
                static fn (CustomEntity $customEntity): string => sprintf('%s%s', $customEntity->getTitle(), $customEntity->getTitle())
            )
            ->eval(
                static fn (Throwable $i): string => $i->getMessage(),
                static fn (string $titles): string => $titles
            );

        self::assertEquals('Empty title', $return);
    }
}
