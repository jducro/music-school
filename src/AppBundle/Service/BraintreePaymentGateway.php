<?php

namespace AppBundle\Service;

use Exception;
use AppBundle\Entity\User;
use Braintree\Customer as BraintreeCustomer;
use Braintree\CreditCard as BraintreeCreditCard;
use Braintree\Configuration as BraintreeConfiguration;
use Braintree\Transaction as BraintreeTransaction;

class BraintreePaymentGateway implements PaymentGatewayServiceInterface
{
    /**
     * @var string
     */
    protected $braintreeEnvironment;

    /**
     * @var string
     */
    protected $braintreeMerchantId;

    /**
     * @var string
     */
    protected $braintreePublicKey;

    /**
     * @var string
     */
    protected $braintreePrivateKey;

    /**
     * @param string $braintreeEnvironment
     */
    public function setBraintreeEnvironment($braintreeEnvironment)
    {
        $this->braintreeEnvironment = $braintreeEnvironment;
    }

    /**
     * @param string $braintreeMerchantId
     */
    public function setBraintreeMerchantId($braintreeMerchantId)
    {
        $this->braintreeMerchantId = $braintreeMerchantId;
    }

    /**
     * @param string $braintreePublicKey
     */
    public function setBraintreePublicKey($braintreePublicKey)
    {
        $this->braintreePublicKey = $braintreePublicKey;
    }

    /**
     * @param string $braintreePrivateKey
     */
    public function setBraintreePrivateKey($braintreePrivateKey)
    {
        $this->braintreePrivateKey = $braintreePrivateKey;
    }


    /**
     * @param User $user
     * @return string
     */
    public function getCustomerId(User $user)
    {
        return $user->getBraintreeCustomerId();
    }

    public function getCustomerPaymentMethods(User $user)
    {
        $cards = [];
        if ($customerId = $this->getCustomerId($user)) {
            $customer = BraintreeCustomer::find($customerId);
            foreach ($customer->paymentMethods as $card) {
                $cards[] = [
                    'brand' => $card->cardType,
                    'number' => 'XX ' . $card->last4,
                    'number' => $card->maskedNumber,
                    'expiration' => $card->expirationMonth . '/' . $card->expirationYear,
                    'country' => $card->customerLocation,
                ];
            }
        }
        return $cards;
    }

    /**
     * @param User $user
     * @param $request
     * @throws
     * @return User
     */
    public function addCustomer(User $user, $request)
    {
        $result = BraintreeCustomer::create([
            'id'    => 'userid-'.$user->getId(),
            'email' => $user->getEmail(),
            "creditCard" => [
                "number"            => $request->request->get("number"),
                "cvv"               => $request->request->get("cvv"),
                "expirationMonth"   => $request->request->get("month"),
                "expirationYear"    => $request->request->get("year"),
            ],
        ]);
        if ($result->success === true) {
            $user->setBraintreeCustomerId($result->customer->id);
        } else {
            throw new Exception("Braintree create customer failed");
        }
        return $result->success;
    }

    public function initIntegration()
    {
        BraintreeConfiguration::environment($this->braintreeEnvironment);
        BraintreeConfiguration::merchantId($this->braintreeMerchantId);
        BraintreeConfiguration::publicKey($this->braintreePublicKey);
        BraintreeConfiguration::privateKey($this->braintreePrivateKey);
    }

    /**
     * @param User $user
     * @param $request
     * @return boolean
     */
    public function addCard(User $user, $request)
    {
        $result = BraintreeCreditCard::create([
            "customerId"        => $this->getCustomerId($user),
            "number"            => $request->request->get("number"),
            "cvv"               => $request->request->get("cvv"),
            "expirationMonth"   => $request->request->get("month"),
            "expirationYear"    => $request->request->get("year"),
        ]);
        return $result->success;
    }

    /**
     * @return string
     */
    public function getAddCardTemplate()
    {
        return 'AppBundle:Payment:braintree.addCard.html.twig';
    }

    /**
     * @param \AppBundle\Entity\User $user
     * @param float $amount
     * @return boolean
     */
    public function chargeUser(User $user, float $amount, $description)
    {
        //get braintree customer
        $customer = BraintreeCustomer::find($this->getCustomerId($user));

        $result = BraintreeTransaction::sale(
            [
                'paymentMethodToken' => $customer->creditCards[0]->token,
                'amount' => round($amount),
            ]
        );
        return $result;
    }
}
