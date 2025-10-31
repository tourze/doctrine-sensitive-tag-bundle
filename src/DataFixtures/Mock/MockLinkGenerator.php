<?php

declare(strict_types=1);

namespace Tourze\DoctrineSensitiveTagBundle\DataFixtures\Mock;

use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Tourze\EasyAdminMenuBundle\Service\LinkGeneratorInterface;

/**
 * Mock 的 LinkGenerator 实现，用于测试
 * 放在 DataFixtures 命名空间下以符合 PHPStan 规则
 */
#[AsAlias(id: LinkGeneratorInterface::class, public: true)]
class MockLinkGenerator implements LinkGeneratorInterface
{
    public function getCurdListPage(string $entityClass): string
    {
        return '/admin/test';
    }

    public function extractEntityFqcn(string $url): ?string
    {
        return null;
    }

    public function setDashboard(string $dashboardControllerFqcn): void
    {
        // Mock implementation - no-op
    }
}
