<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Lesson;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class LessonsController extends Controller
{
	/**
	 * @Route("/api/lessons", name="lessons")
	 * @ApiDoc(
	 *   resource=true,
	 *   description="Get all lessons",
	 * )
	 * @return JsonResponse $response Lessons list
	 */
	public function getAllAction()
	{
		$serializer = SerializerBuilder::create()->build();

		$lessons = $this->getDoctrine()
			->getManager()
			->getRepository('AppBundle:Lesson')
			->findAll();

		$json = $serializer->serialize($lessons, 'json', SerializationContext::create()->enableMaxDepthChecks());
		return new Response($json);
	}


	/**
	 * @Route("/api/lessons/{id}", requirements={"id" = "\d+"}, name="lesson_by_id")
	 * @ApiDoc(
	 *   resource=true,
	 *   description="Get Lessons by id",
	 * )
	 * @param integer $id Lesson Id
	 * @return JsonResponse $response Lesson
	 */
	public function getByIdAction($id)
	{
		$serializer = SerializerBuilder::create()->build();

		$lesson = $this->getDoctrine()
			->getManager()
			->getRepository('AppBundle:Lesson')
			->find($id);

		$json = $serializer->serialize($lesson, 'json', SerializationContext::create()->enableMaxDepthChecks());
		return new Response($json);
	}

	/**
	 * @Route("/api/lessons/level/{level_id}", requirements={"level_id" = "\d+"}, name="lessons_by_level")
	 * @ApiDoc(
	 *   resource=true,
	 *   description="Get Lessons list by level id",
	 * )
	 * @param integer $level_id Level Id
	 * @return JsonResponse $response List of lessons
	 */
	public function getByLevelAction($level_id)
	{
		$serializer = SerializerBuilder::create()->build();

		$em = $this->getDoctrine()
			->getManager();
		$level = $em->getRepository('AppBundle:Level')
			->find($level_id);

		$lessons = $level->getLessons();

		$json = $serializer->serialize($lessons, 'json', SerializationContext::create()->enableMaxDepthChecks());
		return new Response($json);
	}

}
