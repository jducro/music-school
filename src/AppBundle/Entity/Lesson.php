<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Instrument;
use AppBundle\Entity\Level;
use AppBundle\Entity\User;

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
     * @var Instrument
	 */
    private $instrument;
    /**
     * @var Level
	 */
    private $level;

	/**
	 * @var \Doctrine\Common\Collections\Collection
	 */
	private $users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Instrument
     */
    public function getInstrument()
    {
        return $this->instrument;
    }

    /**
     * Set instrument
     *
     * @param Instrument $instrument
     *
     * @return Lesson
     */
    public function setInstrument(Instrument $instrument = null)
    {
        $this->instrument = $instrument;

        return $this;
    }

    /**
     * Get level
     *
     * @return Level
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set level
     *
     * @param Level $level
     *
     * @return Lesson
     */
    public function setLevel(Level $level = null)
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

    /**
     * Add user
     *
     * @param User $user
     *
     * @return Lesson
     */
    public function addUser(User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param User $user
     */
    public function removeUser(User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
