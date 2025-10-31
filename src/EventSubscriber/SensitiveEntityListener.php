<?php

declare(strict_types=1);

namespace Tourze\DoctrineSensitiveTagBundle\EventSubscriber;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\Common\Util\ClassUtils;
use Doctrine\ORM\Event\PostLoadEventArgs;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreRemoveEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Tourze\DoctrineSensitiveTagBundle\Entity\TouchLog;
use Tourze\DoctrineSensitiveTagBundle\Model\SensitiveTagAwareInterface;

/**
 * 在读取数据时判断并记录敏感标签
 */
#[AsDoctrineListener(event: Events::prePersist, priority: self::PRIORITY)]
#[AsDoctrineListener(event: Events::preUpdate, priority: self::PRIORITY)]
#[AsDoctrineListener(event: Events::preRemove, priority: self::PRIORITY)]
#[AsDoctrineListener(event: Events::postLoad, priority: self::PRIORITY)]
class SensitiveEntityListener
{
    public const PRIORITY = -999;

    public function prePersist(PrePersistEventArgs $eventArgs): void
    {
        $this->handle($eventArgs);
    }

    public function preUpdate(PreUpdateEventArgs $eventArgs): void
    {
        $this->handle($eventArgs);
    }

    public function preRemove(PreRemoveEventArgs $eventArgs): void
    {
        $this->handle($eventArgs);
    }

    public function postLoad(PostLoadEventArgs $eventArgs): void
    {
        $this->handle($eventArgs);
    }

    /** @phpstan-ignore missingType.generics */
    private function handle(LifecycleEventArgs $eventArgs): void
    {
        $entity = $eventArgs->getObject();
        if (!$entity instanceof SensitiveTagAwareInterface) {
            return;
        }
        if (!$entity->isResourceSensitive()) {
            return;
        }

        $log = new TouchLog();
        $log->setObjectClass(ClassUtils::getClass($entity));
        $log->setObjectId(method_exists($entity, 'getId') ? $entity->getId() : 'unknown');
        $log->setAction(match ($eventArgs::class) {
            PrePersistEventArgs::class => 'create',
            PreUpdateEventArgs::class => 'update',
            PreRemoveEventArgs::class => 'remove',
            PostLoadEventArgs::class => 'load',
            default => 'unknown',
        });

        // 标记资源需要记录LOG
        $eventArgs->getObjectManager()->persist($log);
        // 如果是 PostLoad 的话，那我们直接记录到数据库
        if ($eventArgs instanceof PostLoadEventArgs) {
            $eventArgs->getObjectManager()->flush();
        }
    }
}
