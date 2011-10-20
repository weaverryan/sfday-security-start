<?php

namespace SfDay\BlogBundle\DataFixtures\Orm;

use Doctrine\Common\DataFixtures\FixtureInterface;
use SfDay\BlogBundle\Entity\Post;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class LoadPosts extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
{
    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load($manager)
    {
        $jack = $manager->merge($this->getReference('user-jack'));
        $jill = $manager->merge($this->getReference('user-jill'));

        $post1 = new Post();
        $post1->setTitle('Oldest post');
        $post1->setBody('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quis elit at magna eleifend tincidunt at vel ante. Fusce facilisis luctus luctus. Praesent auctor viverra elit quis viverra. Nam vehicula lobortis eros at iaculis. In hac habitasse platea dictumst. Proin in placerat enim. Proin vehicula nulla quis quam molestie faucibus vitae id odio');
        $post1->setPublishedAt(new \DateTime('yesterday'));
        $post1->setAuthor($jack);
        $manager->persist($post1);

        $post2 = new Post();
        $post2->setTitle('Newest post');
        $post2->setBody('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quis elit at magna eleifend tincidunt at vel ante. Fusce facilisis luctus luctus. Praesent auctor viverra elit quis viverra. Nam vehicula lobortis eros at iaculis. In hac habitasse platea dictumst. Proin in placerat enim. Proin vehicula nulla quis quam molestie faucibus vitae id odio');
        $post2->setPublishedAt(new \DateTime('today'));
        $post2->setAuthor($jill);
        $manager->persist($post2);

        $manager->flush();

        $this->setupAcl($post1);
        $this->setupAcl($post2);

    }

    protected function setupAcl(Post $post)
    {
        $aclProvider = $this->container->get('security.acl.provider');
        $objectIdentity = ObjectIdentity::fromDomainObject($post);
        $acl = $aclProvider->createAcl($objectIdentity);

        $user = $post->getAuthor();

        // must do this manually, to avoid proxy issues (see below)
        $securityIdentity = new UserSecurityIdentity($user->getUsername(), 'SfDay\\UserBundle\\Entity\\User');

        // should be able to do this, but be careful!!! User is a proxy, which
        // will mess everything up!
        //$securityIdentity = UserSecurityIdentity::fromAccount($user);

        // grant owner access
        $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
        $aclProvider->updateAcl($acl);
    }

    public function getOrder()
    {
        return 2;
    }
}