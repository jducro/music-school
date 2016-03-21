<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Instrument;
use AppBundle\Entity\Level;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LevelFixture extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * Load default users
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $levels = [
            'Débutant',
            'Intermédiaire',
            'Avancé',
        ];

        foreach ($levels as $i => $level) {
            $object = new Level();
            $object->setName($level);
            $manager->persist($object);

            $this->setReference('level-' . $i, $object);
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
        return 2;
    }
}