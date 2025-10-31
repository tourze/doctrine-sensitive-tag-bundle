<?php

namespace Tourze\DoctrineSensitiveTagBundle\Tests\Model;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\DoctrineSensitiveTagBundle\Model\SensitiveTagAwareInterface;

/**
 * @internal
 */
#[CoversClass(SensitiveTagAwareInterface::class)]
final class SensitiveTagAwareInterfaceTest extends TestCase
{
    public function testInterfaceExists(): void
    {
        $this->assertTrue(interface_exists(SensitiveTagAwareInterface::class));
    }

    public function testInterfaceMethodSignature(): void
    {
        $reflectionClass = new \ReflectionClass(SensitiveTagAwareInterface::class);
        $this->assertTrue($reflectionClass->hasMethod('isResourceSensitive'));

        $method = $reflectionClass->getMethod('isResourceSensitive');
        $this->assertTrue($method->hasReturnType());
        $returnType = $method->getReturnType();
        $this->assertInstanceOf(\ReflectionNamedType::class, $returnType);
        $this->assertEquals('bool', $returnType->getName());
        $this->assertFalse($returnType->allowsNull());
    }

    public function testInterfaceContract(): void
    {
        // 测试接口合约：任何实现该接口的类都必须提供 isResourceSensitive 方法
        $reflectionClass = new \ReflectionClass(SensitiveTagAwareInterface::class);
        $methods = $reflectionClass->getMethods();

        $this->assertCount(1, $methods);
        $this->assertEquals('isResourceSensitive', $methods[0]->getName());
        $this->assertTrue($methods[0]->isPublic());
        $this->assertFalse($methods[0]->isStatic());
    }
}
