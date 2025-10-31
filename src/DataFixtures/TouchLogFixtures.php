<?php

declare(strict_types=1);

namespace Tourze\DoctrineSensitiveTagBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\When;
use Tourze\DoctrineSensitiveTagBundle\Entity\TouchLog;

#[When(env: 'test')]
class TouchLogFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $touchLog1 = new TouchLog();
        $touchLog1->setObjectClass('TestEntity');
        $touchLog1->setObjectId('test-id-1');
        $touchLog1->setAction('create');

        $touchLog2 = new TouchLog();
        $touchLog2->setObjectClass('TestEntity');
        $touchLog2->setObjectId('test-id-2');
        $touchLog2->setAction('update');

        $touchLog3 = new TouchLog();
        $touchLog3->setObjectClass('AnotherEntity');
        $touchLog3->setObjectId('another-id-1');
        $touchLog3->setAction('delete');

        $manager->persist($touchLog1);
        $manager->persist($touchLog2);
        $manager->persist($touchLog3);

        $manager->flush();
    }
}
