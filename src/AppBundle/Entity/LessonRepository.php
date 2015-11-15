<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * LessonRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LessonRepository extends EntityRepository
{
	/**
	 * @param $level_id
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getLessonsByLevelId($level_id)
	{
		$em = $this->getEntityManager();
		$level = $em->getRepository('AppBundle:Level')
			->find($level_id);

		if (!$level) {
			throw new NotFoundHttpException('Level not found');
		}

		return $level->getLessons();
	}

	/**
	 * @param $level_id
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getTopLessonsByLevelId($level_id)
	{
		$qb = $this
			->createQueryBuilder('l')
			->leftJoin('l.users');
		$em = $this->getEntityManager();
		$level = $em->getRepository('AppBundle:Level')
			->find($level_id);

		if (!$level) {
			throw new NotFoundHttpException('Level not found');
		}

		return $level->getLessons();
	}
}