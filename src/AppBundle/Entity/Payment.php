<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 *
 */
class Payment
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned"=true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    protected $user;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $success;

    /**
     * @ORM\Column(type="string")
     */
    protected $integration;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @ORM\Column(type="integer")
     */
    protected $amount;

    /**
     * @ORM\Column(type="string")
     */
    protected $reference;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PaymentGateway")
     */
    protected $paymentGateway;

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
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * @param mixed $success
     */
    public function setSuccess($success)
    {
        $this->success = $success;
    }

    /**
     * @return mixed
     */
    public function getIntegration()
    {
        return $this->integration;
    }

    /**
     * @param mixed $integration
     */
    public function setIntegration($integration)
    {
        $this->integration = $integration;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param mixed $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * @return PaymentGateway
     */
    public function getPaymentGateway(): PaymentGateway
    {
        return $this->paymentGateway;
    }

    /**
     * @param PaymentGateway $paymentGateway
     */
    public function setPaymentGateway(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }
}
