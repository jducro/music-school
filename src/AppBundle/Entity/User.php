<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * User
 *
 * @ORM\Table(name="app_users")
 * @ORM\Entity
 */
class User implements AdvancedUserInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=64)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=64)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=60, unique=true)
     */
    private $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var Collection $roles
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Role", inversedBy="users")
     */
    private $roles;

    /**
     * @var Collection $lessons
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Lesson", inversedBy="users")
     * @ORM\JoinTable(name="users_lessons",
     *   joinColumns={
     *     @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="lesson_id", referencedColumnName="id")
     *   }
     * )
     */
    private $lessons;

    /**
     * @var string $stripeCustomerId
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $stripeCustomerId = null;

    /**
     * @var string $braintreeCustomerId
     *
     * @ORM\Column(type="string", nullable=true)
     */
    protected $braintreeCustomerId = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lessons = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
        $this->setUsername($email);
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLessons()
    {
        return $this->lessons;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $lessons
     */
    public function setLessons($lessons)
    {
        $this->lessons = $lessons;
    }

    /**
     * @return mixed
     */
    public function getStripeCustomerId()
    {
        return $this->stripeCustomerId;
    }

    /**
     * @param mixed $stripeCustomerId
     */
    public function setStripeCustomerId($stripeCustomerId)
    {
        $this->stripeCustomerId = $stripeCustomerId;
    }

    /**
     * @return mixed
     */
    public function getBraintreeCustomerId()
    {
        return $this->braintreeCustomerId;
    }

    /**
     * @param mixed $braintreeCustomerId
     */
    public function setBraintreeCustomerId($braintreeCustomerId)
    {
        $this->braintreeCustomerId = $braintreeCustomerId;
    }

    public function eraseCredentials()
    {
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->active;
    }

    public function getSalt()
    {
        return 'YPWuEZNxr8TKijAtv7';
    }

    public function getRoles()
    {
        $rolesArray = [];
        foreach ($this->roles->toArray() as $role) {
            if ($role instanceof  Role) {
                $rolesArray[] = $role->getRole();
            }
        }
        return $rolesArray;
    }

    public function setRoles(Collection $roles)
    {
        $this->roles = $roles;
    }

    public function addRole(Role $role)
    {
        if (!$this->roles->contains($role)) {
            $this->roles->add($role);
        }

    }

    public function removeRole(Role $role)
    {
        $this->roles->removeElement($role);
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

}

