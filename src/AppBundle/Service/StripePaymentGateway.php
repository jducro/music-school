<?php

namespace AppBundle\Service;

use AppBundle\Entity\Payment;
use \Exception;
use AppBundle\Entity\User;
use Stripe\Customer as StripeCustomer;
use Stripe\Charge as StripeCharge;
use Stripe\Card as StripeCard;
use Stripe\Stripe;

class StripePaymentGateway extends AbstractDoctrineService implements PaymentGatewayServiceInterface
{
    /**
     * @var string
     */
    protected $apiKey;


    /**
     * @param string $apiKey
     */
    public function setStripeApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param User $user
     * @return string
     */
    public function getCustomerId(User $user)
    {
        return $user->getStripeCustomerId();
    }

    public function getCustomerPaymentMethods(User $user)
    {
        $cards = [];
        if ($customerId = $this->getCustomerId($user)) {
            $customer = StripeCustomer::retrieve($customerId);
            foreach ($customer->sources->data as $card) {
                $cards[] = [
                    'brand' => $card->brand,
                    'number' => 'XX ' . $card->last4,
                    'expiration' => $card->exp_month . '/' . $card->exp_year,
                ];
            }
        }
        return $cards;
    }

    /**
     * @param User $user
     * @param $request
     * @throws Exception
     * @return User
     */
    public function addCustomer(User $user, $request)
    {
        $stripeToken = $request->request->get('token');
        //register stripe customer if necessary
        $customer = StripeCustomer::create([
            "description" => sprintf("UserId %s email %s", $user->getId(), $user->getEmail()),
            "source" => $stripeToken, // obtained with Stripe.js
            "email" => $user->getEmail(),
        ]);
        if (!$customer->id) {
            throw new Exception("stripe create customer failed");
        }
        $user->setStripeCustomerId($customer->id);
        return true;
    }

    public function initIntegration()
    {
        Stripe::setApiKey($this->apiKey);
    }

    /**
     * @param User $user
     * @param $request
     * @return boolean
     */
    public function addCard(User $user, $request)
    {
        $stripeToken = $request->request->get('token');
        if ($stripeToken) {
            $customer = StripeCustomer::retrieve($this->getCustomerId($user));
            $card = $customer->sources->create(['source' => $stripeToken]);
            return ($card instanceof StripeCard);
        }
        return false;
    }

    /**
     * @return string
     */
    public function getAddCardTemplate()
    {
        return 'AppBundle:Payment:stripe.addCard.html.twig';
    }

    /**
     * @param \AppBundle\Entity\User $user
     * @param float $amount
     * @param string $description
     * @throws Exception
     * @return boolean
     */
    public function chargeUser(User $user, float $amount, $description)
    {
        $result = StripeCharge::create([
            "amount"        => round($amount * 100),
            "currency"      => "gbp",
            "customer"      => $this->getCustomerId($user),
            "description"   => $description,
        ]);

        $payment = new Payment();
        $payment->setUser($user);
        $payment->setSuccess(true);
        $payment->setDate(new \DateTime());
        $payment->setIntegration('stripe');
        $payment->setAmount($amount * 100);
        $payment->setReference($result->id);
        $this->persist($payment);
        $this->flush();

        if ($result->status != "succeeded") {
            throw new Exception("stripe payment failed");
        }
        return $result;
    }
}
