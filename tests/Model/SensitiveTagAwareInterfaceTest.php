<?php

namespace Tourze\DoctrineSensitiveTagBundle\Tests\Model;

use PHPUnit\Framework\TestCase;
use Tourze\DoctrineSensitiveTagBundle\Model\SensitiveTagAwareInterface;

class SensitiveTagAwareInterfaceTest extends TestCase
{
    public function testInterfaceExists(): void
    {
        $this->assertTrue(interface_exists(SensitiveTagAwareInterface::class));
    }

    public function testMethodSignature(): void
    {
        $reflectionClass = new \ReflectionClass(SensitiveTagAwareInterface::class);
        $this->assertTrue($reflectionClass->hasMethod('isResourceSensitive'));

        $method = $reflectionClass->getMethod('isResourceSensitive');
        $this->assertTrue($method->hasReturnType());
        $this->assertEquals('bool', $method->getReturnType()->getName());
    }

    public function testImplementation(): void
    {
        // 创建一个匿名实现接口的类
        $sensitiveImpl = new class implements SensitiveTagAwareInterface {
            private bool $sensitive = true;

            public function isResourceSensitive(): bool
            {
                return $this->sensitive;
            }

            public function setSensitive(bool $value): void
            {
                $this->sensitive = $value;
            }
        };

        // 测试默认为敏感资源
        $this->assertTrue($sensitiveImpl->isResourceSensitive());

        // 测试切换为非敏感资源
        $sensitiveImpl->setSensitive(false);
        $this->assertFalse($sensitiveImpl->isResourceSensitive());
    }
}
