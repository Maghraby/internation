<?php

namespace App\DataFixtures;

use App\Entity\Group;
use App\DataFixtures\UserFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class GroupFixtures extends Fixture
{
    public const GROUP_REFERENCE = 'group';

    public function load(ObjectManager $manager)
    {
        $group = new Group();
        $group->setName('Group1');
        $manager->persist($group);
        $manager->flush();

        $group2 = new Group();
        $group2->setName('Group2');
        $manager->persist($group2);
        $manager->flush();

        $this->addReference(self::GROUP_REFERENCE, $group);
    }
}
