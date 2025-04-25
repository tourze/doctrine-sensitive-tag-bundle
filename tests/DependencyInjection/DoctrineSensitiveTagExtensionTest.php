<?php

namespace Tourze\DoctrineSensitiveTagBundle\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tourze\DoctrineSensitiveTagBundle\DependencyInjection\DoctrineSensitiveTagExtension;
use Tourze\DoctrineSensitiveTagBundle\EventSubscriber\SensitiveEntityListener;

class DoctrineSensitiveTagExtensionTest extends TestCase
{
    public function testLoad(): void
    {
        $container = new ContainerBuilder();
        $extension = new DoctrineSensitiveTagExtension();

        $extension->load([], $container);

        // 验证服务是否已注册
        $this->assertTrue($container->has(SensitiveEntityListener::class));

        // 验证服务是否具有正确的标签
        $definition = $container->getDefinition(SensitiveEntityListener::class);
        $this->assertTrue($definition->isAutowired());
        $this->assertTrue($definition->isAutoconfigured());
    }
}
