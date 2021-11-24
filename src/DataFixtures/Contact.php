<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Contact extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $contact = new \App\Entity\Contact();

        $contact->setName("CARUELLE");
        $contact->setFirstname("Nathan");
        $contact->setEmail("nathan.caruelle@epsi.fr");
        $contact->setMessage("Bonjour, ceci est un message");
        $contact->setSubject("Message Test");
        $contact->setNewletter(true);

        $manager->persist($contact);

        $manager->flush();
    }
}
