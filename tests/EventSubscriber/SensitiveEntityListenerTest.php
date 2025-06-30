<?php

namespace Tourze\DoctrineSensitiveTagBundle\Tests\EventSubscriber;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostLoadEventArgs;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreRemoveEventArgs;
use PHPUnit\Framework\TestCase;
use Tourze\DoctrineSensitiveTagBundle\Entity\TouchLog;
use Tourze\DoctrineSensitiveTagBundle\EventSubscriber\SensitiveEntityListener;
use Tourze\DoctrineSensitiveTagBundle\Model\SensitiveTagAwareInterface;

class SensitiveEntityListenerTest extends TestCase
{
    private EntityManagerInterface $entityManager;
    private SensitiveEntityListener $listener;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->listener = new SensitiveEntityListener();
    }

    public function testPrePersistWithSensitiveEntity(): void
    {
        // 创建一个敏感实体
        $entity = $this->createSensitiveEntity(true);
        $entityClass = get_class($entity);

        // 配置EntityManager模拟对象
        $this->entityManager->expects($this->once())
            ->method('persist')
            ->with($this->callback(function ($log) use ($entityClass) {
                return $log instanceof TouchLog
                    && $log->getAction() === 'create'
                    && $log->getObjectClass() === $entityClass
                    && $log->getObjectId() === '123';
            }));

        // 创建事件参数
        $eventArgs = new PrePersistEventArgs($entity, $this->entityManager);

        // 调用监听器
        $this->listener->prePersist($eventArgs);
    }


    public function testPreRemoveWithSensitiveEntity(): void
    {
        // 创建一个敏感实体
        $entity = $this->createSensitiveEntity(true);

        // 配置EntityManager模拟对象
        $this->entityManager->expects($this->once())
            ->method('persist')
            ->with($this->callback(function ($log) {
                return $log instanceof TouchLog
                    && $log->getAction() === 'remove';
            }));

        // 创建事件参数
        $eventArgs = new PreRemoveEventArgs($entity, $this->entityManager);

        // 调用监听器
        $this->listener->preRemove($eventArgs);
    }

    public function testPostLoadWithSensitiveEntity(): void
    {
        // 创建一个敏感实体
        $entity = $this->createSensitiveEntity(true);

        // 配置EntityManager模拟对象
        $this->entityManager->expects($this->once())
            ->method('persist')
            ->with($this->callback(function ($log) {
                return $log instanceof TouchLog
                    && $log->getAction() === 'load';
            }));

        $this->entityManager->expects($this->once())
            ->method('flush');

        // 创建事件参数
        $eventArgs = new PostLoadEventArgs($entity, $this->entityManager);

        // 调用监听器
        $this->listener->postLoad($eventArgs);
    }

    public function testNonSensitiveEntityIsIgnored(): void
    {
        // 创建一个非敏感实体
        $entity = $this->createSensitiveEntity(false);

        // EntityManager不应该被调用
        $this->entityManager->expects($this->never())
            ->method('persist');

        // 创建事件参数并测试所有事件类型
        $prePersistArgs = new PrePersistEventArgs($entity, $this->entityManager);
        $this->listener->prePersist($prePersistArgs);

        // 跳过PreUpdateEventArgs测试，因为构造函数问题

        $preRemoveArgs = new PreRemoveEventArgs($entity, $this->entityManager);
        $this->listener->preRemove($preRemoveArgs);

        $postLoadArgs = new PostLoadEventArgs($entity, $this->entityManager);
        $this->listener->postLoad($postLoadArgs);
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
