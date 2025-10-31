<?php

namespace Tourze\DoctrineSensitiveTagBundle\Tests\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\DoctrineSensitiveTagBundle\Entity\TouchLog;
use Tourze\PHPUnitDoctrineEntity\AbstractEntityTestCase;

/**
 * @internal
 */
#[CoversClass(TouchLog::class)]
final class TouchLogTest extends AbstractEntityTestCase
{
    /**
     * @return TouchLog
     */
    protected function createEntity(): object
    {
        return new TouchLog();
    }

    /** @return iterable<string, array{0: string, 1: string}> */
    public static function propertiesProvider(): iterable
    {
        yield 'objectClass' => ['objectClass', 'App\Entity\User'];
        yield 'objectId' => ['objectId', '123'];
        yield 'action' => ['action', 'view'];
    }

    public function testStringRepresentation(): void
    {
        $touchLog = $this->createEntity();
        $touchLog->setObjectClass('App\Entity\User');
        $touchLog->setObjectId('123');
        $touchLog->setAction('view');

        $expected = 'TouchLog[App\Entity\User:123:view]';
        $this->assertEquals($expected, (string) $touchLog);
    }
}
