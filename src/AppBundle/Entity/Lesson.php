<?php

namespace AppBundle\Entity;
use JMS\Serializer\Annotation\MaxDepth;

/**
 * Lesson
 */
class Lesson
{
    /**
     * @var string
	 */
    public $name;
    /**
     * @var integer
     */
    private $id;
    /**
     * @var string
	 */
    private $description;

    /**
     * @var string
	 */
    private $image_url;

    /**
     * @var \AppBundle\Entity\Instrument
	 * @MaxDepth(1)
     */
    private $instrument;
    /**
     * @var \AppBundle\Entity\Level
	 * @MaxDepth(1)
     */
    private $level;

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
     * @return Lesson
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Lesson
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get imageUrl
     *
     * @return string
     */
    public function getImageUrl()
    {
        return $this->image_url;
    }

    /**
     * Set imageUrl
     *
     * @param string $imageUrl
     *
     * @return Lesson
     */
    public function setImageUrl($imageUrl)
    {
        $this->image_url = $imageUrl;

        return $this;
    }

    /**
     * Get instrument
     *
     * @return \AppBundle\Entity\Instrument
     */
    public function getInstrument()
    {
        return $this->instrument;
    }

    /**
     * Set instrument
     *
     * @param \AppBundle\Entity\Instrument $instrument
     *
     * @return Lesson
     */
    public function setInstrument(\AppBundle\Entity\Instrument $instrument = null)
    {
        $this->instrument = $instrument;

        return $this;
    }

    /**
     * Get level
     *
     * @return \AppBundle\Entity\Level
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set level
     *
     * @param \AppBundle\Entity\Level $level
     *
     * @return Lesson
     */
    public function setLevel(\AppBundle\Entity\Level $level = null)
    {
        $this->level = $level;

        return $this;
    }

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->name;
	}
}
