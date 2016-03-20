<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Lesson;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LessonsController extends FOSRestController
{
	/**
	 * @Route("/api/lessons/{id}", requirements={"id" = "\d+"}, name="lesson_by_id", options={"expose"=true})
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

		if ($lesson instanceof Lesson && null !== $lesson->getName()) {
			$lesson = [
				'id' => $lesson->getId(),
				'name' => $lesson->getName(),
				'description' => $lesson->getDescription(),
				'image_url' => $lesson->getImageUrl(),
				'instrument' => [
					'name' => $lesson->getInstrument()->getName()
				],
				'level' => [
					'name' => $lesson->getLevel()->getName()
				],
			];
		}

		$json = $serializer->serialize($lesson, 'json', SerializationContext::create()->enableMaxDepthChecks());
		return new Response($json);
	}

	/**
	 * @Route(
	 *     "/api/lessons/level/{level_slug}",
	 *     requirements={"level_slug" = "[a-z]+"},
	 *     name="lessons_by_level",
	 *     options={"expose"=true}
	 * )
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

		$levelLessons = $this->getDoctrine()
			->getRepository('AppBundle:Lesson')
			->getLessonsByLevel($level_slug);

		$lessons = [];
		foreach ($levelLessons as $lesson) {
			if ($lesson instanceof Lesson && null !== $lesson->getName()) {
				$lessons[] = [
					'id' => $lesson->getId(),
					'name' => $lesson->getName(),
					'description' => $lesson->getDescription(),
					'image_url' => $lesson->getImageUrl(),
					'instrument' => [
						'name' => $lesson->getInstrument()->getName()
					]
				];
			}
		}

		$json = $serializer->serialize($lessons, 'json', SerializationContext::create()->enableMaxDepthChecks());
		return new Response($json);
	}

	/**
	 * @Route(
	 *     "/api/lessons/level/{level_slug}/top",
	 *     requirements={"level_slug" = "[a-z]+"},
	 *     name="top_lessons_by_level",
	 *     options={"expose"=true}
	 *	 )
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

	/**
	 * @Route("/api/lessons", name="create_lesson")
	 * @Method({"POST"})
	 * @ApiDoc(
	 *   resource=true,
	 *   description="Create a new lesson",
	 * )
	 * @param ParamFetcher $paramFetcher Paramfetcher
	 * @RequestParam(name="name", nullable=false, strict=true, description="Lesson name.")
	 * @RequestParam(name="description", nullable=true, strict=true, description="Lesson description.")
	 * @RequestParam(name="image_url", nullable=true, strict=true, description="Lesson image.")
	 * @RequestParam(name="instrument", nullable=true, strict=true, description="Lesson instrument.")
	 * @RequestParam(name="level", nullable=true, strict=true, description="Lesson level.")
	 * @return JsonResponse|Response $response List of lessons
	 */
	public function createLessonAction(ParamFetcher $paramFetcher)
	{
		$em = $this->getDoctrine()
			->getManager();
		$level = $em->getRepository('AppBundle:Level')
			->findOneBy(['slug' => $paramFetcher->get('level')]);

		if (!$level) {
			throw new NotFoundHttpException('Level not found');
		}
		$instrument = $em->getRepository('AppBundle:Instrument')
			->findOneBy(['slug' => $paramFetcher->get('instrument')]);

		if (!$instrument) {
			throw new NotFoundHttpException('Instrument not found');
		}

		$lesson = new Lesson();
		$lesson->setName($paramFetcher->get('name'));
		$lesson->setDescription($paramFetcher->get('description'));
		$lesson->setImageUrl($paramFetcher->get('image_url'));
		$lesson->setInstrument($instrument);
		$lesson->setLevel($level);

		$em->persist($lesson);
		$em->flush();

		$serializer = SerializerBuilder::create()->build();
		$json = $serializer->serialize($lesson, 'json', SerializationContext::create()->enableMaxDepthChecks());
		return new Response($json);
	}

	/**
	 * @Route("/api/lessons", name="lessons", options={"expose"=true})
	 * @Method({"GET"})
	 * @ApiDoc(
	 *   resource=true,
	 *   description="Get all lessons",
	 * )
	 * @return array Lessons list
	 */
	public function getAllAction()
	{
		$serializer = SerializerBuilder::create()->build();

		$allLessons = $this->getDoctrine()
			->getRepository('AppBundle:Lesson')
			->findAll();

		$lessons = [];
		foreach ($allLessons as $lesson) {
			if ($lesson instanceof Lesson && null !== $lesson->getName()) {
				$lessons[] = [
					'id' => $lesson->getId(),
					'name' => $lesson->getName(),
					'description' => $lesson->getDescription(),
				];
			}
		}

		$json = $serializer->serialize($lessons, 'json', SerializationContext::create()->enableMaxDepthChecks());
		return new Response($json);
	}
}
