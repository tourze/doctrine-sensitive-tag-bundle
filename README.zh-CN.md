# Doctrine敏感数据标记Bundle

[English](README.md) | [中文](README.zh-CN.md)

该Bundle提供了一个机制来标记和跟踪Doctrine实体中的敏感数据。

## 安装

```bash
composer require tourze/doctrine-sensitive-tag-bundle
```

## 功能

- 通过实现`SensitiveTagAwareInterface`接口来标记敏感数据
- 自动记录对敏感数据的访问、创建、更新和删除操作
- 提供了记录敏感数据访问日志的实体和事件订阅器

## 使用方法

1. 实现`SensitiveTagAwareInterface`接口：

```php
use Tourze\DoctrineSensitiveTagBundle\Model\SensitiveTagAwareInterface;

class User implements SensitiveTagAwareInterface
{
    // ...

    public function isResourceSensitive(): bool
    {
        // 判断是否包含敏感数据
        return true;
    }
}
```

2. Bundle会自动记录对敏感实体的操作到`TouchLog`日志表中。

## 数据分级说明

根据《网络安全标准实践指南——网络数据分类分级指引》，数据分为四个级别：

- 1级数据：可公开数据
- 2级数据：内部数据，可能对权益造成轻微危害
- 3级数据：保密数据，可能对权益造成一般危害
- 4级数据：高度保密数据，可能对权益造成严重危害

敏感个人信息通常不低于4级，一般个人信息不低于2级。

## 单元测试

运行以下命令执行单元测试：

```bash
./vendor/bin/phpunit packages/doctrine-sensitive-tag-bundle/tests
```

## 许可

此Bundle在MIT许可下发布。有关更多信息，请参阅[LICENSE](LICENSE)文件。 