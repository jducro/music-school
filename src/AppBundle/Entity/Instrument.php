<?php

namespace AppBundle\Entity;

use JMS\Serializer\Annotation\MaxDepth;

/**
 * Instrument
 */
class Instrument
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;
    /**
     * @var \Doctrine\Common\Collections\Collection
	 * @MaxDepth(1)
     */
    private $lessons;
    /**
     * @var string
     */
    private $slug;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lessons = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Instrument
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->name;
	}

    /**
     * Add lesson
     *
     * @param \AppBundle\Entity\Lesson $lesson
     *
     * @return Instrument
     */
    public function addLesson(\AppBundle\Entity\Lesson $lesson)
    {
        $this->lessons[] = $lesson;

        return $this;
    }

    /**
     * Remove lesson
     *
     * @param \AppBundle\Entity\Lesson $lesson
     */
    public function removeLesson(\AppBundle\Entity\Lesson $lesson)
    {
        $this->lessons->removeElement($lesson);
    }

    /**
     * Get lessons
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLessons()
    {
        return $this->lessons;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Instrument
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }
}
