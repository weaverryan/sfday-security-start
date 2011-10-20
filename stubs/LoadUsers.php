<?php

namespace SfDay\UserBundle\DataFixtures\Orm;

use Doctrine\Common\DataFixtures\FixtureInterface;
use SfDay\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

class LoadUserData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load($manager)
    {
        $jack = $this->getUserManipulator()->create(
            'jack',
            'jack',
            'jack@user.com',
            true,
            false
        );
        $this->getUserManipulator()->addRole('jack', 'ROLE_BLOGGER');
        $this->addReference('user-jack', $jack);

        $jill = $this->getUserManipulator()->create(
            'jill',
            'jill',
            'jill@user.com',
            true,
            false
        );
        $this->getUserManipulator()->addRole('jill', 'ROLE_BLOGGER');
        $this->addReference('user-jill', $jill);
    }

    /**
     * @return \FOS\UserBundle\Util\UserManipulator
     */
    private function getUserManipulator()
    {
        return $this->container->get('fos_user.util.user_manipulator');
    }

    public function getOrder()
    {
        return 1;
    }
}