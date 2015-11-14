<?php
namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Instrument;
use AppBundle\Entity\Lesson;
use AppBundle\Entity\Level;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadDemoData implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		$electric_guitar = new Instrument();
		$electric_guitar->setName('Guitare éléctrique');

		$manager->persist($electric_guitar);

		$instruments[] = $electric_guitar;

		$acoustic_guitar = new Instrument();
		$acoustic_guitar->setName('Guitare acoustique');

		$manager->persist($acoustic_guitar);

		$instruments[] = $acoustic_guitar;

		$piano = new Instrument();
		$piano->setName('Piano');

		$manager->persist($piano);

		$instruments[] = $piano;

		$bass = new Instrument();
		$bass->setName('Basse');

		$manager->persist($bass);

		$instruments[] = $bass;

		$drums = new Instrument();
		$drums->setName('Batterie');

		$manager->persist($drums);

		$instruments[] = $drums;

		$sing = new Instrument();
		$sing->setName('Chant');

		$manager->persist($sing);

		$instruments[] = $sing;

		$beginner = new Level();
		$beginner->setName('Débutant');

		$manager->persist($beginner);

		$levels[] = $beginner;

		$intermediate = new Level();
		$intermediate->setName('Intermédiaire');

		$manager->persist($intermediate);

		$levels[] = $intermediate;

		$advanced = new Level();
		$advanced->setName('Avancé');

		$manager->persist($advanced);

		$levels[] = $advanced;

		$manager->flush();

		foreach ($instruments as $instrument) {
			foreach ($levels as $level) {
				$lesson = new Lesson();
				$lesson->setName($instrument->getName() . ' ' . $level->getName());
				$lesson->setInstrument($instrument);
				$lesson->setLevel($level);

				$lesson->setDescription("Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.");

				$manager->persist($lesson);
				$manager->flush();
			}
		}
	}
}
