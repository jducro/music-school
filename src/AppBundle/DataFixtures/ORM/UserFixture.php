<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Load default users using doctrine fixture
 *
 * Class UserFixture
 */
class UserFixture extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Load default users
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $repository = $manager->getRepository('AppBundle:User');


        // Default admin
        $user = $repository->find(1);
        if ($user === null) {
            $user = new User();
            $user->setName('Test User');
            $user->setEmail('test@test.com');
            $encoder = $this->container->get('security.password_encoder');
            $password = $encoder->encodePassword($user, '123123');
            $user->setPassword($password);
            $user->setActive(true);
            $manager->persist($user);
        }

        $this->addReference('test-user', $user);

        // Test user
        $admin = $repository->find(2);
        if ($admin === null) {
            $admin = new User();
            $admin->setName('Test Admin');
            $admin->setEmail('admin@test.com');
            $encoder = $this->container->get('security.password_encoder');
            $password = $encoder->encodePassword($admin, 'password');
            $admin->setPassword($password);
            $admin->setActive(true);
            $manager->persist($admin);
        }

        $this->addReference('admin-user', $admin);


        $manager->flush();
    }

    /**
     * The order in which fixtures will be loaded, the lower the number, the sooner that this fixture is loaded
     *
     * @return int
     */
    public function getOrder()
    {
        return 4;
    }
}
