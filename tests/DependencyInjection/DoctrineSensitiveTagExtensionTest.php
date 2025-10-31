<?php

namespace Tourze\DoctrineSensitiveTagBundle\Tests\DependencyInjection;

use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tourze\DoctrineSensitiveTagBundle\DependencyInjection\DoctrineSensitiveTagExtension;
use Tourze\DoctrineSensitiveTagBundle\EventSubscriber\SensitiveEntityListener;
use Tourze\PHPUnitSymfonyUnitTest\AbstractDependencyInjectionExtensionTestCase;

/**
 * @internal
 */
#[CoversClass(DoctrineSensitiveTagExtension::class)]
final class DoctrineSensitiveTagExtensionTest extends AbstractDependencyInjectionExtensionTestCase
{
    public function testExtensionLoadsServices(): void
    {
        $container = new ContainerBuilder();
        $container->setParameter('kernel.environment', 'test');
        $extension = new DoctrineSensitiveTagExtension();

        $extension->load([], $container);

        $this->assertTrue($container->hasDefinition(SensitiveEntityListener::class));
    }
}
