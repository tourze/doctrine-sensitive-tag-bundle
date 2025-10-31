<?php

declare(strict_types=1);

namespace Tourze\DoctrineSensitiveTagBundle\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\DoctrineSensitiveTagBundle\DoctrineSensitiveTagBundle;
use Tourze\PHPUnitSymfonyKernelTest\AbstractBundleTestCase;

/**
 * @internal
 */
#[CoversClass(DoctrineSensitiveTagBundle::class)]
#[RunTestsInSeparateProcesses]
final class DoctrineSensitiveTagBundleTest extends AbstractBundleTestCase
{
}
