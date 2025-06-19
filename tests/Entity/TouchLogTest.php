<?php

namespace Tourze\DoctrineSensitiveTagBundle\Tests\Entity;

use PHPUnit\Framework\TestCase;
use Tourze\DoctrineSensitiveTagBundle\Entity\TouchLog;

class TouchLogTest extends TestCase
{
    public function testGetterAndSetter(): void
    {
        $touchLog = new TouchLog();

        // 测试 ObjectClass 的 getter 和 setter
        $objectClass = 'TestObjectClass';
        $touchLog->setObjectClass($objectClass);
        $this->assertEquals($objectClass, $touchLog->getObjectClass());

        // 测试 ObjectId 的 getter 和 setter
        $objectId = '12345';
        $touchLog->setObjectId($objectId);
        $this->assertEquals($objectId, $touchLog->getObjectId());

        // 测试 Action 的 getter 和 setter
        $action = 'test_action';
        $touchLog->setAction($action);
        $this->assertEquals($action, $touchLog->getAction());

        // 测试 CreateTime 的 getter 和 setter
        $createTime = new \DateTimeImmutable();
        $touchLog->setCreateTime($createTime);
        $this->assertSame($createTime, $touchLog->getCreateTime());

        // 测试 CreatedFromIp 的 getter 和 setter
        $createdFromIp = '127.0.0.1';
        $touchLog->setCreatedFromIp($createdFromIp);
        $this->assertEquals($createdFromIp, $touchLog->getCreatedFromIp());

        // 测试 CreatedBy 的 getter 和 setter
        $createdBy = 'testUser';
        $touchLog->setCreatedBy($createdBy);
        $this->assertEquals($createdBy, $touchLog->getCreatedBy());

        // 测试 ID 的默认值和 getter
        $this->assertEquals(0, $touchLog->getId());
    }

    public function testFluentInterface(): void
    {
        $touchLog = new TouchLog();

        // 测试链式调用
        $this->assertInstanceOf(TouchLog::class, $touchLog->setObjectClass('TestClass'));
        $this->assertInstanceOf(TouchLog::class, $touchLog->setObjectId('123'));
        $this->assertInstanceOf(TouchLog::class, $touchLog->setAction('test'));
        $this->assertInstanceOf(TouchLog::class, $touchLog->setCreateTime(new \DateTimeImmutable()));
    }
}
