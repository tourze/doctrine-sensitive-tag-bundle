<?php

namespace Tourze\DoctrineSensitiveTagBundle\Tests\EventSubscriber;

use Doctrine\ORM\Event\PostLoadEventArgs;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreRemoveEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\DoctrineSensitiveTagBundle\Entity\TouchLog;
use Tourze\DoctrineSensitiveTagBundle\EventSubscriber\SensitiveEntityListener;
use Tourze\DoctrineSensitiveTagBundle\Model\SensitiveTagAwareInterface;
use Tourze\DoctrineSensitiveTagBundle\Tests\Service\MockLinkGenerator;
use Tourze\PHPUnitSymfonyKernelTest\AbstractEventSubscriberTestCase;

/**
 * @internal
 */
#[CoversClass(SensitiveEntityListener::class)]
#[RunTestsInSeparateProcesses]
final class SensitiveEntityListenerTest extends AbstractEventSubscriberTestCase
{
    private SensitiveEntityListener $listener;

    protected function onSetUp(): void
    {
        $this->listener = self::getService(SensitiveEntityListener::class);
        $this->cleanTouchLogTable();
    }

    /**
     * 清理 TouchLog 表以确保测试隔离
     */
    private function cleanTouchLogTable(): void
    {
        $entityManager = self::getEntityManager();
        $entityManager->getConnection()->executeStatement('DELETE FROM doctrine_sensitive_tag_touch_log');
    }

    public function testPrePersistWithSensitiveEntity(): void
    {
        // 创建一个敏感实体
        $entity = $this->createSensitiveEntity(true);
        $entityClass = get_class($entity);
        $entityManager = self::getEntityManager();

        // 创建事件参数
        $eventArgs = new PrePersistEventArgs($entity, $entityManager);

        // 调用监听器
        $this->listener->prePersist($eventArgs);

        // 验证是否创建了 TouchLog
        $entityManager->flush();
        // @phpstan-ignore doctrine.noGetRepositoryOutsideService
        $logs = $entityManager->getRepository(TouchLog::class)->findAll();

        $this->assertCount(1, $logs);
        $log = $logs[0];
        $this->assertSame('create', $log->getAction());
        $this->assertSame($entityClass, $log->getObjectClass());
        $this->assertSame('123', $log->getObjectId());
    }

    public function testPreRemoveWithSensitiveEntity(): void
    {
        // 创建一个敏感实体
        $entity = $this->createSensitiveEntity(true);
        $entityManager = self::getEntityManager();

        // 创建事件参数
        $eventArgs = new PreRemoveEventArgs($entity, $entityManager);

        // 调用监听器
        $this->listener->preRemove($eventArgs);

        // 验证是否创建了 TouchLog
        $entityManager->flush();
        // @phpstan-ignore doctrine.noGetRepositoryOutsideService
        $logs = $entityManager->getRepository(TouchLog::class)->findAll();

        $this->assertCount(1, $logs);
        $log = $logs[0];
        $this->assertSame('remove', $log->getAction());
    }

    public function testPostLoadWithSensitiveEntity(): void
    {
        // 创建一个敏感实体
        $entity = $this->createSensitiveEntity(true);
        $entityManager = self::getEntityManager();

        // 创建事件参数
        $eventArgs = new PostLoadEventArgs($entity, $entityManager);

        // 调用监听器
        $this->listener->postLoad($eventArgs);

        // 验证是否创建了 TouchLog（postLoad 会立即 flush）
        // @phpstan-ignore doctrine.noGetRepositoryOutsideService
        $logs = $entityManager->getRepository(TouchLog::class)->findAll();

        $this->assertCount(1, $logs);
        $log = $logs[0];
        $this->assertSame('load', $log->getAction());
    }

    public function testPreUpdateWithSensitiveEntity(): void
    {
        // 创建一个敏感实体
        $entity = $this->createSensitiveEntity(true);
        $entityManager = self::getEntityManager();

        // 创建事件参数 - PreUpdateEventArgs 需要变更集
        $changeSet = [];
        $eventArgs = new PreUpdateEventArgs($entity, $entityManager, $changeSet);

        // 调用监听器
        $this->listener->preUpdate($eventArgs);

        // 验证是否创建了 TouchLog
        $entityManager->flush();
        // @phpstan-ignore doctrine.noGetRepositoryOutsideService
        $logs = $entityManager->getRepository(TouchLog::class)->findAll();

        $this->assertCount(1, $logs);
        $log = $logs[0];
        $this->assertSame('update', $log->getAction());
    }

    public function testNonSensitiveEntityIsIgnored(): void
    {
        // 创建一个非敏感实体
        $entity = $this->createSensitiveEntity(false);
        $entityManager = self::getEntityManager();

        // 创建事件参数并测试所有事件类型
        $prePersistArgs = new PrePersistEventArgs($entity, $entityManager);
        $this->listener->prePersist($prePersistArgs);

        $changeSet = [];
        $preUpdateArgs = new PreUpdateEventArgs($entity, $entityManager, $changeSet);
        $this->listener->preUpdate($preUpdateArgs);

        $preRemoveArgs = new PreRemoveEventArgs($entity, $entityManager);
        $this->listener->preRemove($preRemoveArgs);

        $postLoadArgs = new PostLoadEventArgs($entity, $entityManager);
        $this->listener->postLoad($postLoadArgs);

        // 验证没有创建任何 TouchLog
        $entityManager->flush();
        // @phpstan-ignore doctrine.noGetRepositoryOutsideService
        $logs = $entityManager->getRepository(TouchLog::class)->findAll();
        $this->assertCount(0, $logs);
    }

    private function createSensitiveEntity(bool $isSensitive): object
    {
        return new class($isSensitive) implements SensitiveTagAwareInterface {
            private bool $sensitive;

            public function __construct(bool $sensitive)
            {
                $this->sensitive = $sensitive;
            }

            public function isResourceSensitive(): bool
            {
                return $this->sensitive;
            }

            public function getId(): string
            {
                return '123';
            }
        };
    }
}
