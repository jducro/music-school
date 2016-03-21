<?php

namespace AppBundle\Service;

use RuntimeException;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Class DoctrineService
 *
 * @package AppBundle\Service
 */
abstract class AbstractDoctrineService implements ObjectRepository
{
    /**
     * @var \Doctrine\ORM\EntityManager;
     */
    protected $manager;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    protected $repository;

    /**
     * @return EntityManager
     */
    public function getManager()
    {
        if (! $this->manager instanceof EntityManager) {
            throw new RuntimeException("entity manager dependency not set");
        }
        return $this->manager;
    }

    /**
     * @param EntityManager $manager
     */
    public function setManager(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return ObjectRepository
     */
    public function getRepository()
    {
        if (! $this->repository instanceof ObjectRepository) {
            throw new RuntimeException("repository dependency not set");
        }
        return $this->repository;
    }

    /**
     * @param string $repository
     */
    public function setRepository(string $repository)
    {
        $this->repository = $this->getManager()->getRepository($repository);
    }

    /**
     * Facade for Repository find
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return $this->getRepository()->find($id);
    }

    /**
     * Facade for Repository findAll
     *
     * @return array
     */
    public function findAll()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * Facade for Repository findBy
     *
     * @param array $criteria
     * @param array|null $orderBy
     * @param null $limit
     * @param null $offset
     *
     * @return array
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->getRepository()->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * Facade for Repository findOneBy
     *
     * @param array $criteria
     * @return object
     */
    public function findOneBy(array $criteria)
    {
        return $this->getRepository()->findOneBy($criteria);
    }

    /**
     * Facade for Repository getClassName
     *
     * @return string
     */
    public function getClassName()
    {
        return get_class($this->getRepository());
    }

    /**
     * Facade for EntityManager flush
     *
     * @param null $entity
     */
    public function flush($entity = null)
    {
        $em = $this->getManager();

        $em->flush($entity);
    }

    /**
     * Facade for Entity Manager detach
     *
     * @param $entity
     */
    public function detach($entity)
    {
        $em = $this->getManager();

        $em->detach($entity);
    }

    /**
     * Facade for Entity Manager persist
     *
     * @param $entity
     */
    public function persist($entity)
    {
        $em = $this->getManager();

        $em->persist($entity);
    }

    /**
     * Facade for EntityManager remove
     *
     * @param $entity
     */
    public function remove($entity)
    {
        $em = $this->getManager();

        $em->remove($entity);
    }
}
