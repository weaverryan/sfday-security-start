<?php

namespace SfDay\BlogBundle\DataFixtures\Orm;

use Doctrine\Common\DataFixtures\FixtureInterface;
use SfDay\BlogBundle\Entity\Post;

class LoadPosts implements FixtureInterface
{
    public function load($manager)
    {
        $post1 = new Post();
        $post1->setTitle('Oldest post');
        $post1->setBody('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quis elit at magna eleifend tincidunt at vel ante. Fusce facilisis luctus luctus. Praesent auctor viverra elit quis viverra. Nam vehicula lobortis eros at iaculis. In hac habitasse platea dictumst. Proin in placerat enim. Proin vehicula nulla quis quam molestie faucibus vitae id odio');
        $post1->setPublishedAt(new \DateTime('yesterday'));
        $manager->persist($post1);

        $post2 = new Post();
        $post2->setTitle('Newest post');
        $post2->setBody('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc quis elit at magna eleifend tincidunt at vel ante. Fusce facilisis luctus luctus. Praesent auctor viverra elit quis viverra. Nam vehicula lobortis eros at iaculis. In hac habitasse platea dictumst. Proin in placerat enim. Proin vehicula nulla quis quam molestie faucibus vitae id odio');
        $post2->setPublishedAt(new \DateTime('today'));
        $manager->persist($post2);

        $manager->flush();

    }
}