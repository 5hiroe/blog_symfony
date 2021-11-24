<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Article extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $article = new \App\Entity\Article();

        $article->setName("Article Test");
        $article->setContent("Je viens d'écrire le 1er article de ce blog, ggwp !");
        $article->setSlug("articleset001");

        $manager->persist($article);

        $manager->flush();
    }
}
