<?php

namespace SfDay\UserBundle\DataFixtures\Orm;

use Doctrine\Common\DataFixtures\FixtureInterface;
use SfDay\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUser implements FixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load($manager)
    {
        $jack = new User();
        $jack->setUsername('jack');
        $jack->setPlainPassword('jack');
        $jack->setFirstName('Jack');
        // TODO - the plainPassword must be encoded, set on the password field
        $manager->persist($jack);

        $jill = new User();
        $jill->setUsername('jill');
        $jill->setPlainPassword('jill');
        // TODO - the plainPassword must be encoded, set on the password field
        $jill->setFirstName('Jill');
        $manager->persist($jack);

        $manager->flush();
    }
}