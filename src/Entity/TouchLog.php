<?php

declare(strict_types=1);

namespace Tourze\DoctrineSensitiveTagBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Tourze\DoctrineIndexedBundle\Attribute\IndexColumn;
use Tourze\DoctrineIpBundle\Traits\CreatedFromIpAware;
use Tourze\DoctrineTimestampBundle\Traits\CreateTimeAware;
use Tourze\DoctrineUserBundle\Traits\CreatedByAware;

#[ORM\Entity]
#[ORM\Table(name: 'doctrine_sensitive_tag_touch_log', options: ['comment' => '实体接触日志'])]
class TouchLog implements \Stringable
{
    use CreateTimeAware;
    use CreatedByAware;
    use CreatedFromIpAware;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER, options: ['comment' => 'ID'])]
    private int $id = 0;

    #[IndexColumn]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    #[ORM\Column(length: 255, options: ['comment' => '对象类名'])]
    private string $objectClass;

    #[IndexColumn]
    #[Assert\NotBlank]
    #[Assert\Length(max: 64)]
    #[ORM\Column(length: 64, options: ['comment' => '对象ID'])]
    private string $objectId;

    #[Assert\NotBlank]
    #[Assert\Length(max: 20)]
    #[ORM\Column(length: 20, options: ['comment' => '操作动作'])]
    private string $action;

    public function getId(): int
    {
        return $this->id;
    }

    public function getObjectClass(): string
    {
        return $this->objectClass;
    }

    public function setObjectClass(string $objectClass): void
    {
        $this->objectClass = $objectClass;
    }

    public function getObjectId(): string
    {
        return $this->objectId;
    }

    public function setObjectId(string $objectId): void
    {
        $this->objectId = $objectId;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function setAction(string $action): void
    {
        $this->action = $action;
    }

    public function __toString(): string
    {
        return sprintf('TouchLog[%s:%s:%s]', $this->objectClass, $this->objectId, $this->action);
    }
}
