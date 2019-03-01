<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public const ADMIN_USER_REFERENCE = 'admin-user';

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setRole('ROLE_ADMIN');
        $user->setName('Mahmoud');
        $user->setApiToken('REAL_TOKEN');
        $user->setCreatedAt(new \DateTime);
        $user->setUpdatedAt(new \DateTime);

        $manager->persist($user);
        $manager->flush();


        $user2 = new User();
        $user2->setName('Ahmed');
        $user2->setApiToken('ANOTHER_TOKEN');
        $user2->setCreatedAt(new \DateTime);
        $user2->setUpdatedAt(new \DateTime);

        $manager->persist($user2);
        $manager->flush();

        $this->addReference(self::ADMIN_USER_REFERENCE, $user);
    }
}
