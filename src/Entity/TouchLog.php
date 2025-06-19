<?php

namespace Tourze\DoctrineSensitiveTagBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Tourze\DoctrineIndexedBundle\Attribute\IndexColumn;
use Tourze\DoctrineIpBundle\Attribute\CreateIpColumn;
use Tourze\DoctrineTimestampBundle\Traits\CreateTimeAware;
use Tourze\DoctrineUserBundle\Traits\CreatedByAware;

#[ORM\Entity]
#[ORM\Table(name: 'doctrine_sensitive_tag_touch_log', options: ['comment' => '实体接触日志'])]
class TouchLog implements \Stringable
{
    use CreateTimeAware;
    use CreatedByAware;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER, options: ['comment' => 'ID'])]
    private ?int $id = 0;

    #[IndexColumn]
    #[ORM\Column(length: 255, options: ['comment' => '对象类名'])]
    private string $objectClass;

    #[IndexColumn]
    #[ORM\Column(length: 64, options: ['comment' => '对象ID'])]
    private string $objectId;

    #[ORM\Column(length: 20, options: ['comment' => '操作动作'])]
    private string $action;

    #[CreateIpColumn]
    #[ORM\Column(length: 45, nullable: true, options: ['comment' => '创建时IP'])]
    private ?string $createdFromIp = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObjectClass(): string
    {
        return $this->objectClass;
    }

    public function setObjectClass(string $objectClass): static
    {
        $this->objectClass = $objectClass;

        return $this;
    }

    public function getObjectId(): string
    {
        return $this->objectId;
    }

    public function setObjectId(string $objectId): static
    {
        $this->objectId = $objectId;

        return $this;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function setAction(string $action): static
    {
        $this->action = $action;

        return $this;
    }

    public function getCreatedFromIp(): ?string
    {
        return $this->createdFromIp;
    }

    public function setCreatedFromIp(?string $createdFromIp): void
    {
        $this->createdFromIp = $createdFromIp;
    }

    public function __toString(): string
    {
        return sprintf('TouchLog[%s:%s:%s]', $this->objectClass, $this->objectId, $this->action);
    }
}
