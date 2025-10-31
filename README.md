# Doctrine Sensitive Tag Bundle

[English](README.md) | [中文](README.zh-CN.md)

[![Latest Version](https://img.shields.io/packagist/v/tourze/doctrine-sensitive-tag-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/doctrine-sensitive-tag-bundle)
[![Total Downloads](https://img.shields.io/packagist/dt/tourze/doctrine-sensitive-tag-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/doctrine-sensitive-tag-bundle)
[![PHP Version](https://img.shields.io/packagist/php-v/tourze/doctrine-sensitive-tag-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/doctrine-sensitive-tag-bundle)
[![License](https://img.shields.io/packagist/l/tourze/doctrine-sensitive-tag-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/doctrine-sensitive-tag-bundle)
[![Build Status](https://img.shields.io/github/actions/workflow/status/tourze/php-monorepo/ci.yml?style=flat-square)](https://github.com/tourze/php-monorepo/actions)

A Symfony bundle to mark and track sensitive data in Doctrine entities, 
providing automatic logging of access operations for sensitive data.

## Features

- Mark sensitive data through the `SensitiveTagAwareInterface` interface
- Automatically log access, creation, update, and deletion operations on sensitive data
- Provides entities and event subscribers for recording sensitive data access logs
- Supports data classification according to network security standards
- Seamless integration with Doctrine ORM and Symfony framework

## Requirements

- PHP 8.1 or higher
- Symfony 7.3 or higher
- Doctrine ORM 3.0 or higher
- Doctrine Bundle 2.13 or higher

## Installation

```bash
composer require tourze/doctrine-sensitive-tag-bundle
```

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

2. The bundle will automatically record operations on sensitive entities in the 
   `TouchLog` table.

## Advanced Usage

### Custom Touch Log Configuration

You can customize the touch logging behavior by implementing custom event listeners
or extending the default `SensitiveEntityListener`.

### Data Classification Levels

According to "Network Security Standard Practice Guide - Network Data 
Classification Guidelines", data is classified into four levels:

- Level 1: Public data
- Level 2: Internal data, may cause minor harm to rights and interests
- Level 3: Confidential data, may cause general harm to rights and interests
- Level 4: Highly confidential data, may cause serious harm to rights and interests

Sensitive personal information should be at least Level 4, general personal 
information at least Level 2.

## Running Tests

Execute the following command to run unit tests:

```bash
./vendor/bin/phpunit packages/doctrine-sensitive-tag-bundle/tests
```

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Run tests to ensure everything works
5. Submit a pull request

Please ensure your code follows the project's coding standards and includes 
appropriate tests.

## License

This bundle is released under the MIT License. See the [LICENSE](LICENSE) file 
for more information.
