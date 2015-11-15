<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Lesson;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class LessonsController extends Controller
{
	/**
	 * @Route("/api/lessons", name="lessons")
	 * @Method({"GET"})
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
			->getRepository('AppBundle:Lesson')
			->findAll();

		$json = $serializer->serialize($lessons, 'json', SerializationContext::create()->enableMaxDepthChecks());
		return new Response($json);
	}


	/**
	 * @Route("/api/lessons/{id}", requirements={"id" = "\d+"}, name="lesson_by_id")
	 * @Method({"GET"})
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
			->getRepository('AppBundle:Lesson')
			->find($id);

		$json = $serializer->serialize($lesson, 'json', SerializationContext::create()->enableMaxDepthChecks());
		return new Response($json);
	}

	/**
	 * @Route("/api/lessons/level/{level_slug}", requirements={"level_slug" = "[a-z]+"}, name="lessons_by_level")
	 * @Method({"GET"})
	 * @ApiDoc(
	 *   resource=true,
	 *   description="Get Lessons list by level slug",
	 * )
	 * @param string $level_slug Level Slug
	 * @return JsonResponse|Response $response List of lessons
	 */
	public function getByLevelAction($level_slug)
	{
		$serializer = SerializerBuilder::create()->build();

		$lessons = $this->getDoctrine()
			->getRepository('AppBundle:Lesson')
			->getLessonsByLevel($level_slug);

		$json = $serializer->serialize($lessons, 'json', SerializationContext::create()->enableMaxDepthChecks());
		return new Response($json);
	}

	/**
	 * @Route("/api/lessons/level/{level_slug}/top", requirements={"level_slug" = "[a-z]+"}, name="top_lessons_by_level")
	 * @Method({"GET"})
	 * @ApiDoc(
	 *   resource=true,
	 *   description="Get Top 6 Lessons list by level slug",
	 * )
	 * @param string $level_slug Level Slug
	 * @return JsonResponse|Response $response List of lessons
	 */
	public function getTopByLevelAction($level_slug)
	{
		$serializer = SerializerBuilder::create()->build();

		$lessons = $this->getDoctrine()
			->getRepository('AppBundle:Lesson')
			->getTopLessonsByLevel($level_slug);

		$json = $serializer->serialize($lessons, 'json', SerializationContext::create()->enableMaxDepthChecks());
		return new Response($json);
	}

}
