<?php

namespace Tourze\DoctrineSensitiveTagBundle\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tourze\DoctrineSensitiveTagBundle\DoctrineSensitiveTagBundle;

class DoctrineSensitiveTagBundleTest extends TestCase
{
    public function testBundleInheritance(): void
    {
        $bundle = new DoctrineSensitiveTagBundle();

        // 验证是否继承自Symfony的Bundle类
        $this->assertInstanceOf(Bundle::class, $bundle);
    }
}
