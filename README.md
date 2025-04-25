# Doctrine Sensitive Tag Bundle

[English](README.md) | [中文](README.zh-CN.md)

A Symfony bundle to mark and track sensitive data in Doctrine entities.

## Installation

```bash
composer require tourze/doctrine-sensitive-tag-bundle
```

## Features

- Mark sensitive data through the `SensitiveTagAwareInterface` interface
- Automatically log access, creation, update, and deletion operations on sensitive data
- Provides entities and event subscribers for recording sensitive data access logs

## Usage

1. Implement the `SensitiveTagAwareInterface`:

```php
use Tourze\DoctrineSensitiveTagBundle\Model\SensitiveTagAwareInterface;

class User implements SensitiveTagAwareInterface
{
    // ...

    public function isResourceSensitive(): bool
    {
        // Determine if this entity contains sensitive data
        return true;
    }
}
```

2. The bundle will automatically record operations on sensitive entities in the `TouchLog` table.

## Data Classification Levels

According to "Network Security Standard Practice Guide - Network Data Classification Guidelines", data is classified into four levels:

- Level 1: Public data
- Level 2: Internal data, may cause minor harm to rights and interests
- Level 3: Confidential data, may cause general harm to rights and interests
- Level 4: Highly confidential data, may cause serious harm to rights and interests

Sensitive personal information should be at least Level 4, general personal information at least Level 2.

## Running Tests

Execute the following command to run unit tests:

```bash
./vendor/bin/phpunit packages/doctrine-sensitive-tag-bundle/tests
```

## License

This bundle is released under the MIT License. See the [LICENSE](LICENSE) file for more information.
