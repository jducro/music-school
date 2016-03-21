<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Instrument;
use AppBundle\Entity\Lesson;
use AppBundle\Entity\Level;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LessonFixture extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 6; $i++) {
            /** @var Instrument $instrument */
            $instrument = $this->getReference('instrument-' . $i);
            for ($j = 0; $j < 3; $j++) {
                /** @var Level $level */
                $level = $this->getReference('level-' . $j);
                $lesson = new Lesson();
                $lesson->setName($instrument->getName() . ' ' . $level->getName());
                $lesson->setInstrument($instrument);
                $lesson->setLevel($level);
                $lesson->setImageUrl('img/lessons/' . ($j + 1 + 3 * $i) . '.png');

                $lesson->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.");

                $manager->persist($lesson);
            }
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
        return 3;
    }
}