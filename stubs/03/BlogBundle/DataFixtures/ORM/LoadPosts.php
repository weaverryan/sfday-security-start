<?php

namespace SfDay\BlogBundle\DataFixtures\Orm;

use Doctrine\Common\DataFixtures\FixtureInterface;
use SfDay\BlogBundle\Entity\Post;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

class LoadPosts extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
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
    }

    public function getOrder()
    {
        return 2;
    }
}