<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Instrument;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class InstrumentFixture extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * Load default users
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $instruments = [
            'Guitare éléctrique',
            'Guitare acoustique',
            'Piano',
            'Basse',
            'Batterie',
            'Chant',
        ];

        foreach ($instruments as $i => $instrument) {
            $object = new Instrument();
            $object->setName($instrument);
            $manager->persist($object);

            $this->setReference('instrument-' . $i, $object);
        }

        $manager->flush();
    }

    /**
     * The order in which fixtures will be loaded, the lower the number, the sooner that this fixture is loaded
     *
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}